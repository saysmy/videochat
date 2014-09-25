<?php
class RechargeController extends CController {
    public $layout='//layouts/common';

    public function actionCenter() {
        if (!CUser::checkLogin()) {
            $userInfo = null;
        }
        else {
            $userInfo = CUser::getInfoByUid($_SESSION['uid']);
        }
        $this->render('recharge', array('userInfo' => $userInfo));
    }

    public function actionAlipay($money) {
        if (!CUser::checkLogin()) {
            return ToolUtils::ajaxOut(100);
        }
        $recharge = new Recharge;
        $recharge->uid = $_COOKIE['uid'];
        $recharge->money = $money;
        $recharge->coin = $money;
        $recharge->pay_type = PAY_TYPE_ALI;
        $recharge->time = date('Y-m-d H:i:s');
        $recharge->status = RECHARGE_INIT;
        $recharge->ali_trade_no = 0;
        if (!$recharge->save()) {
            return ToolUtils::ajaxOut(101, 'generate pay number error', $recharge->getErrors());
        }
        $pay_number = $recharge->id;
        $pay_number = PAY_NUMBER_BASE + $pay_number;

        $alipay_config = Yii::app()->params['alipayConfig'];

        require_once(ALIPAY_LIB_PATH . "alipay_submit.class.php");
        $parameter = array(
                "service" => "create_direct_pay_by_user",
                "partner" => ALIPAY_PARTNER,
                "payment_type"  => 1,
                "notify_url"    => ALIPAY_NOTIRY_URL,
                "return_url"    => ALIPAY_RETURN_URL,
                "seller_email"  => ALIPAY_ACCOUNT,
                "out_trade_no"  =>  $pay_number,
                "subject"   => '肥皂网充值订单',
                "total_fee" => $money,
                "body"  => '肥皂网充值订单',
                "show_url"  => RECHARGE_SHOW_URL . '/' . $pay_number,
                "anti_phishing_key" => '',
                "exter_invoke_ip"   => '',
                "_input_charset"    => 'utf-8',
        );
        $alipaySubmit = new AlipaySubmit(array(
                'partner' => ALIPAY_PARTNER,
                'key' => ALIPAY_KEY,
                'sign_type' => 'MD5',
                'input_charset' => 'utf-8',
                'cacert' => ALIPAY_CERT,
                'transport' => 'http',
            )
        );
        $html_text = $alipaySubmit->buildRequestForm($parameter,'get', '确认');
        $this->renderPartial('alipay_redirect', array('html' => $html_text));
    }

    public function actionAlipayReturn() {
        require_once(ALIPAY_LIB_PATH . 'alipay_notify.class.php');

        if (!isset($_GET['out_trade_no']) || !isset($_GET['trade_no']) || !isset($_GET['trade_status'])) {
            throw new CHttpException(500,'参数缺失');
        }

        $alipayNotify = new AlipayNotify(array(
                'partner' => ALIPAY_PARTNER,
                'key' => ALIPAY_KEY,
                'sign_type' => 'MD5',
                'input_charset' => 'utf-8',
                'cacert' => ALIPAY_CERT,
                'transport' => 'http',
            )
        );
        $verify_result = $alipayNotify->verifyReturn();
        if($verify_result) {//验证成功
            $out_trade_no = $_GET['out_trade_no'];
            //支付宝交易号
            $trade_no = $_GET['trade_no'];
            //交易状态
            $trade_status = $_GET['trade_status'];

            if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
                //支付成功
                $success = true;
            }
            else {
                $success = false;
            }
        }
        else {
            $success = false;
        }

        $record = Recharge::model()->findByPk($out_trade_no - PAY_NUMBER_BASE);

        $user = CUser::getInfoByUid($record->uid);

        $this->render('return', array('alipayTradeNo' => $trade_no,
                                      'TradeNo' => $out_trade_no,
                                      'payTime' => date('Y-m-d H:i:s'),
                                      'uid' => $record->uid,
                                      'nickname' => $user['nickname'],
                                      'coin' => $record->coin,
                                      'success' => $success,
                                )
                    );
    }

    public function actionAlipayNotify() {
        $a = 1;
        $a['uid'];
        $tradeInfo = 'out_trade_no:' . $_POST['out_trade_no'] . ' trade_no:' . $_POST['trade_no'] . ' trade_status:' . $_POST['trade_status'];
        Yii::log($tradeInfo, CLogger::LEVEL_INFO, 'alipay');
        require_once(ALIPAY_LIB_PATH . "alipay_notify.class.php");
        $alipayNotify = new AlipayNotify(array(
                'partner' => ALIPAY_PARTNER,
                'key' => ALIPAY_KEY,
                'sign_type' => 'MD5',
                'input_charset' => 'utf-8',
                'cacert' => ALIPAY_CERT,
                'transport' => 'http',
            )
        );
        $verify_result = $alipayNotify->verifyNotify();

        if($verify_result) {//验证成功
            $out_trade_no = $_POST['out_trade_no'];
            //支付宝交易号
            $trade_no = $_POST['trade_no'];
            //交易状态
            $trade_status = $_POST['trade_status'];

            Yii::log('验证成功 ' . $tradeInfo, CLogger::LEVEL_INFO, 'alipay');

            
            if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {
                $record = Recharge::model()->findByPk($out_trade_no - PAY_NUMBER_BASE);
                if (!$record) {
                    Yii::log('订单未找到 out_trade_no:' . $_POST['out_trade_no'] . ' trade_no:' . $_POST['trade_no'] . ' trade_status:' . $_POST['trade_status'], CLogger::LEVEL_ERROR, 'alipay');
                }
                else {
                    $record->status = RECHARGE_COMPLETE;
                    $record->ali_trade_no = $trade_no;
                    if (!$record->save()) {
                        Yii::log('update recharge record error:' . json_encode($record->getErrors()) . ' ' . $tradeInfo, CLogger::LEVEL_ERROR, 'alipay');
                    }
                    else {
                        Yii::app()->db->createCommand("begin")->execute();
                        $userInfo = Yii::app()->db->createCommand('select * from user where id=' . $record['uid'] . ' for update')->queryRow();
                        if ($userInfo) {
                            $user = User::model();
                            if(!$user->updateByPk($userInfo['id'], array('coin' => $userInfo['coin'] + $record['coin']))) {
                                Yii::log('save user coin error uid:' . $record['uid'] . ' error:' . json_encode($user->getErrors()) . ' ' . $tradeInfo, CLogger::LEVEL_ERROR, 'alipay');
                            }
                        }
                        else {
                            Yii::log('get user info error uid:' . $record['uid'] . ' ' . $tradeInfo, CLogger::LEVEL_ERROR, 'alipay');
                        }
                        Yii::app()->db->createCommand("commit")->execute();
                    }
                }
            }

                
            echo "success";     //请不要修改或删除
            
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
        else {
            //验证失败
            Yii::log('验证失败 ' . $tradeInfo, CLogger::LEVEL_ERROR, 'alipay');
            echo "fail";

        }
       
    }

    public function actionReturn() {
        $this->render('return');
    }
}






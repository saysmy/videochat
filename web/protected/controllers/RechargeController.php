<?php
class RechargeController extends CController {
    public $layout='//layouts/index';

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
                $msg = '支付成功';
            }
            else {
                $msg = 'trade_status=' . $_GET['trade_status'];
            }
        }
        else {
            $msg = '验证失败';
        }

        $this->render('return', array('msg' => $msg));

    }

    public function actionAlipayNotify() {
        require_once(ALIPAY_LIB_PATH . "alipay_notify.class.php");
        $alipayNotify = new AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();

        if($verify_result) {//验证成功
            $out_trade_no = $_POST['out_trade_no'];
            //支付宝交易号
            $trade_no = $_POST['trade_no'];
            //交易状态
            $trade_status = $_POST['trade_status'];

            Yii::log('out_trade_no:' . $out_trade_no . ' trade_no:' . $trade_no . ' trade_status:' . $trade_status, CLogger::LEVEL_INFO, 'alipay');

            
            if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {
                $record = Recharge::model()->findByPk($out_trade_no);
                $record->status = RECHARGE_COMPLETE;
                $record->save();
            }

                
            echo "success";     //请不要修改或删除
            
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
        else {
            //验证失败
            echo "fail";

        }
       
    }


}






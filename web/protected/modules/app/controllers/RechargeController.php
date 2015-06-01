<?php
class RechargeController extends CController {

    public function filters() {
        return array(
            array(
                'application.filters.LoginFilter + alipay',
            ),
        );  
    }

    public function actionIndex() {
        $uid = CUser::checkLogin();
        $userInfo = null;
        if ($uid) {
            $userInfo = User::model()->findByPk($uid);
        }
        $this->render('index', array('userInfo' => $userInfo));
    }

    public function actionAlipay($money, $platform) { 

        if ($platform == 'ios') {
            $payType = PAY_TYPE_ALI_IOS;
        }
        else if ($platform == 'android') {
            $payType = PAY_TYPE_ALI_ANDROID;
        }
        else if ($platform == 'webapp') {
            $payType = PAY_TYPE_ALI_WEB_APP;
        }
        else {
            return ToolUtils::ajaxOut(100);
        }

        $uid = CUser::checkLogin();

        $recharge = new Recharge;
        $recharge->uid = $uid;
        $recharge->money = $money;
        $recharge->coin = $money;
        $recharge->pay_type = $payType;
        $recharge->time = date('Y-m-d H:i:s');
        $recharge->status = RECHARGE_INIT;
        $recharge->ali_trade_no = 0;
        if (!$recharge->save()) {
            return ToolUtils::ajaxOut(101, 'generate pay number error', $recharge->getErrors());
        }
        $pay_number = $recharge->id;
        $pay_number = PAY_NUMBER_BASE + $pay_number;

        $alipayConfig = array(
            'partner' => ALIPAY_PARTNER,
            'key' => ALIPAY_KEY,
            'sign_type' => 'MD5',
            'input_charset' => 'utf-8',
            'transport' => 'http',
        );

        //请求业务参数详细
        $req_data = '<direct_trade_create_req><notify_url>' . ALIPAY_NOTIRY_M_URL . '</notify_url><call_back_url>' . ALIPAY_RETURN_M_URL . '/platform/' . $platform . '</call_back_url><seller_account_name>' . ALIPAY_ACCOUNT . '</seller_account_name><out_trade_no>' . $pay_number . '</out_trade_no><subject>肥皂网充值订单</subject><total_fee>' . $money . '</total_fee><merchant_url></merchant_url></direct_trade_create_req>';

        //构造要请求的参数数组，无需改动
        $para_token = array(
                "service" => "alipay.wap.trade.create.direct",
                "partner" => ALIPAY_PARTNER,
                "sec_id" => $alipayConfig['sign_type'],
                "format"    => 'xml',
                "v" => '2.0',
                "req_id"    => $pay_number,
                "req_data"  => $req_data,
                "_input_charset"    => $alipayConfig['input_charset'],
        );

        require_once(ALIPAY_LIB_PATH . "alipay_submit.class.php");

        //建立请求
        $alipaySubmit = new AlipaySubmit($alipayConfig);
        $html_text = $alipaySubmit->buildRequestHttp($para_token);
        //URLDECODE返回的信息
        $html_text = urldecode($html_text);

        //解析远程模拟提交后返回的信息
        $para_html_text = $alipaySubmit->parseResponse($html_text);

        //获取request_token
        $request_token = $para_html_text['request_token'];
        //业务详细
        $req_data = '<auth_and_execute_req><request_token>' . $request_token . '</request_token></auth_and_execute_req>';

        //构造要请求的参数数组，无需改动
        $parameter = array(
                "service" => "alipay.wap.auth.authAndExecute",
                "partner" => ALIPAY_PARTNER,
                "sec_id" => $alipayConfig['sign_type'],
                "format"    => 'xml',
                "v" => '2.0',
                "req_id"    => $pay_number,
                "req_data"  => $req_data,
                "_input_charset"    => $alipayConfig['input_charset'],
        );
        //建立请求
        $alipaySubmit = new AlipaySubmit($alipayConfig);
        $html_text = $alipaySubmit->buildRequestForm($parameter, 'get', '确认');

        $this->renderPartial('alipay_redirect', array('html' => $html_text));

    }

    public function actionAlipayReturn($platform) {
         //计算得出通知验证结果
        $alipayNotify = new AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyReturn();
        if($verify_result) {//验证成功
            
            //商户订单号
            $out_trade_no = $_GET['out_trade_no'];

            //支付宝交易号
            $trade_no = $_GET['trade_no'];

            //交易状态
            $result = $_GET['result'];

            header('Location:/app/recharge');
        }
        else {//验证失败
            echo "验证失败";
        }
       
    }

    public function actionAlipayNotify() {

        Yii::log(var_export($_POST, true), CLogger::LEVEL_INFO, 'alipay');

        //计算得出通知验证结果
        $alipayNotify = new AlipayNotify(array(
                'partner' => ALIPAY_PARTNER,
                'key' => ALIPAY_KEY,
                'sign_type' => 'MD5',
                'input_charset' => 'utf-8',
                'transport' => 'http',
            )
        );
        $verify_result = $alipayNotify->verifyNotify();

        if($verify_result) {//验证成功
            $doc = new DOMDocument();   
            $doc->loadXML($_POST['notify_data']);
            if(!empty($doc->getElementsByTagName( "notify" )->item(0)->nodeValue) ) {
                //商户订单号
                $out_trade_no = $doc->getElementsByTagName( "out_trade_no" )->item(0)->nodeValue;
                //支付宝交易号
                $trade_no = $doc->getElementsByTagName( "trade_no" )->item(0)->nodeValue;
                //交易状态
                $trade_status = $doc->getElementsByTagName( "trade_status" )->item(0)->nodeValue;

                $tradeInfo = 'out_trade_no:' . $out_trade_no . ' trade_no:' . $trade_no . ' trade_status:' . $trade_status;
                
                if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {                            
                    //TRADE_FINISHED状态只在两种情况下出现
                    //1、开通了普通即时到账，买家付款成功后。
                    //2、开通了高级即时到账，从该笔交易成功时间算起，过了签约时的可退款时限（如：三个月以内可退款、一年以内可退款等）后。
                    //TRADE_SUCCESS状态只在一种情况下出现——开通了高级即时到账，买家付款成功后。   
                    $record = Recharge::model()->findByPk($out_trade_no - PAY_NUMBER_BASE);
                    if (!$record) {
                        Yii::log('订单未找到 ' . $tradeInfo, CLogger::LEVEL_ERROR, 'alipay');
                    }
                    else {
                        $record->status = RECHARGE_COMPLETE;
                        $record->ali_trade_no = $trade_no;
                        if (!$record->save()) {
                            Yii::log('update recharge record error:' . json_encode($record->getErrors()) . ' ' . $tradeInfo, CLogger::LEVEL_ERROR, 'alipay');
                        }

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
                echo "success";
            }

            
        }
        else {
            //验证失败
            echo "fail";
        }

    }

}
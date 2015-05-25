<?php
class RechargeController extends CController {

    public actionAlipay($money) {
        if (!($uid = CUser::checkLogin())) {
            return ToolUtils::ajaxOut(100);
        }
        $recharge = new Recharge;
        $recharge->uid = $uid;
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

}
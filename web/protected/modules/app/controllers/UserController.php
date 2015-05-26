<?php
class UserController extends CController {

    public function filters() {
        return array(
            array(
                'application.filters.LoginFilter + updateInfo + getInfo',
            ),
        );  
    }


    public function actionGetPublicKey() {

        if (Yii::app()->session->get('pubKey')) {
            return ToolUtils::ajaxOut(0, '', array('key' => Yii::app()->session->get('pubKey')));
        }

        $config = array(
            "digest_alg" => "sha512",
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );
            
        $res = openssl_pkey_new($config);

        openssl_pkey_export($res, $privKey);

        $pubKey = openssl_pkey_get_details($res);

        Yii::app()->session->add('privKey', $privKey);
        Yii::app()->session->add('pubKey', $pubKey['key']);

        return ToolUtils::ajaxOut(0, '', array('key' => $pubKey['key']));       
    }

    public function actionLogin() {
        $form = new LoginForm;
        $form->attributes = $_POST;

        if (!Yii::app()->session->get('privKey')) {
            return ToolUtils::ajaxOut(203, '密钥失效，请重新申请');
        }

        if (!openssl_private_decrypt(base64_decode($form->password), $password, Yii::app()->session->get('privKey'))) {
            return ToolUtils::ajaxOut(202, '解密失败');
        }
        $form->password = $password;

        if (!$form->validate()) {
            return ToolUtils::ajaxOut(200, '参数错误', $form->getErrors());
        }

        $userIdentity = new UserIdentity($form->username, $form->password);
        if (!$userIdentity->authenticate()) {
            return ToolUtils::ajaxOut(201, '用户名或密码错误');
        }
        $user = $userIdentity->getUser();

        Yii::app()->session->add('uid', $user->id);
        // Yii::app()->session->add('nickname', $user->nickname);

        setcookie('uid', $user->id, $form->remember ? (time() + Yii::app()->params['cookieExpire']) : 0, '/', DOMAIN);
        return ToolUtils::ajaxOut(0, '', array('uid' => $user->id));          
    }

    public function actionQQLogin() {
        $accessToken = Yii::app()->request->getParam('accessToken');
        $openId = Yii::app()->request->getParam('openId');
        $expiredIn = Yii::app()->request->getParam('expiredIn');
        $expiredIn = strtotime($expiredIn) - time();

        include PROJECT_LIB . 'QQConnectAPI/qqConnectAPI.php';

        $user = User::model()->find('qq_openid=:open_id', array(':open_id' => $openId));
        if($user === null) {//新用户
            $qc = new QC;
            $qc->setOpenId($openId);
            $qc->setAccessToken($accessToken);
            $userInfo = $qc->get_user_info();            
            if (!($uid = CUser::qqUserRegister($userInfo, $openId, $accessToken, $expiredIn, SOURCE_FROM_APP_QQ))) {
                throw new Exception(CUser::getError(), 300);
            }
        }
        else {
            $user->qq_accesstoken = $accessToken;
            $user->qq_accessexpire = $expiredIn + time();
            $user->last_login_time = Date('Y-m-d H:i:s');
            $user->setScenario('qqLogin');
            if (!$user->save(true, array('qq_accesstoken', 'qq_accessexpire', 'last_login_time'))) {
                throw new Exception(json_encode($user->getErrors()), 301);
            }
            $uid = $user->id;
        }


        Yii::app()->session->add('uid', $uid);

        setcookie('uid', $uid, 0, '/', DOMAIN);

        ToolUtils::ajaxOut(0);
    }

    public function actionGetMobileVCode($mobile) {
        $mobileForm = new MobileForm;
        $mobileForm->mobile = $mobile;
        if (!$mobileForm->validate()) {
            return ToolUtils::ajaxOut(400, '手机号码格式不正确');
        }
        //频次控制
        if (!ToolUtils::frequencyCheck('getMobileVCode_' . $mobile, 60)) {
            return ToolUtils::ajaxOut(FREQUENCY_ERR, '操作过于频繁');
        }

        $vcode = '1234';
        // $vcode .= rand(0, 9);
        // $vcode .= rand(0, 9);
        // $vcode .= rand(0, 9);
        // $vcode .= rand(0, 9);

        // if (!ToolUtils::sendSms($mobile, $vcode)) {
        //      return ToolUtils::ajaxOut(401, '发送短信失败');           
        // }

        Yii::app()->session->add('mobileVCode_' . $mobile, $vcode);
        Yii::app()->session->add('mobile', $mobile);

        ToolUtils::ajaxOut(0);
    }

    public function actionCheckMobileVCode($vcode) {

        $mobile = Yii::app()->session->get('mobile');
        if (!$mobile) {
            return ToolUtils::ajaxOut(501, '手机号信息丢失');
        }

        if ($vcode == Yii::app()->session->get('mobileVCode_' . $mobile)) {

            Yii::app()->session->add('mobileChecked', true);

            return ToolUtils::ajaxOut(0);
        }
        else {
            return ToolUtils::ajaxOut(500, '手机验证码错误');
        }
    }

    public function actionMobileRegister() {
        $password = Yii::app()->request->getParam('password');
        $nickname = Yii::app()->request->getParam('nickname');
        $sex = Yii::app()->request->getParam('sex');

        $mobile = Yii::app()->session->get('mobile');
        if (!$mobile) {
            return ToolUtils::ajaxOut(600, '手机号信息丢失');
        }

        if (!Yii::app()->session->get('mobileChecked')) {
            return ToolUtils::ajaxOut(603, '手机未验证');
        }

        if (!Yii::app()->session->get('privKey')) {
            return ToolUtils::ajaxOut(604, '密钥失效，请重新申请');
        }

        if (!openssl_private_decrypt(base64_decode($password), $password, Yii::app()->session->get('privKey'))) {
            return ToolUtils::ajaxOut(601, '解密失败');
        }

        if (!($uid = CUser::mobileRegister($mobile, $nickname, $sex, $password, $error))) {
            if (isset($error['mobile'])) {//优先提示手机号码相关错误
                return ToolUtils::ajaxOut(602, $error['mobile'], $error);
            }
            else {
                return ToolUtils::ajaxOut(602, current(current($error)), $error);
            }
            
        }

        Yii::app()->session->add('uid', $user->id);

        //移除本次验证码认证状态
        Yii::app()->session->remove('mobileChecked');

        ToolUtils::ajaxOut(0);
    }

    public function actionLogout() {

        Yii::app()->session->destroy();

        ToolUtils::ajaxOut(0);
    }

    public function actionGetInfo() {
        
        $uid = CUser::checkLogin();

        $userInfo = User::model()->findByPk($uid);
        if (!$userInfo) {
            return ToolUtils::ajaxOut(700, '用户不存在');
        }
        $data = array(
            'id' => (int)$userInfo->id,
            'nickname' => $userInfo->nickname,
            'head_pic' => $userInfo->head_pic_1,
            'sex' => (int)$userInfo->sex,
            'birthday' => date('Y-m-d', strtotime($userInfo->birthday)),
            'coin' => (float)$userInfo->coin,
            'love_num' => (int)LoveRoom::model()->count('uid=' . $uid),
            'follow_num' => 0,
            'moderator_desc' => '',
        );
        $room = Room::model()->find('mid=' . $userInfo->id);
        if ($room) {
            $data['moderator_desc'] = $room->moderator_desc;
            $data['follow_num'] = (int)$room->love_num;
        }

        ToolUtils::ajaxOut(0, '', $data);

    }

    public function actionUpdateInfo() {

        $uid = CUser::checkLogin();

        $nickname = Yii::app()->request->getParam('nickname');
        $sex = Yii::app()->request->getParam('sex');
        $birthday = Yii::app()->request->getParam('birthday');
        $desc = Yii::app()->request->getParam('desc');

        $user = User::model()->findByPk($uid);
        if (!$user) {
            return ToolUtils::ajaxOut(801, '用户不存在');
        }
        $user->nickname = $nickname;
        $user->sex = $sex;
        $user->birthday = $birthday;

        $user->setScenario('appUpdate');

        if (!$user->save(true, array('nickname', 'sex', 'birthday'))) {
            return ToolUtils::ajaxOut(800, current(current($user->getErrors())), $user->getErrors());
        }

        ToolUtils::ajaxOut(0);
    }

    public function actionModifyPassword() {

        $newPassword = trim(Yii::app()->request->getParam('newPassword'));

        $mobile = Yii::app()->session->get('mobile');
        if (!$mobile) {
            return ToolUtils::ajaxOut(900, '手机号信息丢失');
        }

        if (!Yii::app()->session->get('mobileChecked')) {
            return ToolUtils::ajaxOut(901, '手机未验证');
        }

        if (!Yii::app()->session->get('privKey')) {
            return ToolUtils::ajaxOut(905, '密钥失效，请重新申请');
        }

        if (!openssl_private_decrypt(base64_decode($newPassword), $newPassword, Yii::app()->session->get('privKey'))) {
            return ToolUtils::ajaxOut(902, '解密失败');
        }

        $user = User::model()->find('mobile=:mobile', array(':mobile' => $mobile));
        if (!$user) {
            return ToolUtils::ajaxOut(903, '手机号未注册');
        }

        $user->password = $newPassword;
        if (!$user->save(true, array('password'))) {
            return ToolUtils::ajaxOut(904, current(current($user->getErrors())));
        }

        ToolUtils::ajaxOut(0);

    }

    
}











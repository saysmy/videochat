<?php

class UserController extends Controller
{
	public $layout='//layouts/common';
	public $loginUrl;

 	public function actions()
    { 
            return array( 
                // captcha action renders the CAPTCHA image displayed on the contact page
                'captcha'=>array(
                        'class'=>'CCaptchaAction',
                        'backColor'=>0xFFFFFF, 
                        'maxLength'=>'4',       // 最多生成几个字符
                        'minLength'=>'4',       // 最少生成几个字符
                       	'height'=>'40'
                ), 
            ); 
    }


	public function actionQQLogin($callback) {

		include dirname(__FILE__) . '/../../../lib/QQConnectAPI/qqConnectAPI.php';

		$qc = new QC();

		//QQ回调老域名，新域名在QQ开发平台设置了，但是不生效
		$qc->set_callback_argv('http://' . 'www.feizao001.com' . '/user/QQCallback/', array('redirect_url' => $callback));
		header('Location: ' . $qc->get_login_url());
	}

	public function actionQQCallback($redirect_url) {
		@session_start();

		include dirname(__FILE__) . '/../../../lib/QQConnectAPI/qqConnectAPI.php';

		$qc = new QC();
		$access_token = $qc->qq_callback();
		$open_id = $qc->get_openid();

		Yii::log(json_encode($access_token), CLogger::LEVEL_INFO);

		$user = User::model()->find('qq_openid=:open_id', array(':open_id' => $open_id));
		if($user === null) {//新用户
			$user = new User();
			$userInfo = $qc->get_user_info();
			$user->username = QQ_LOGIN_PRE . $open_id;
			$user->nickname = $userInfo['nickname'] ? $userInfo['nickname'] : 'QQ用户';
			$user->sex = $userInfo['gender'] == '女' ? 2 : 1;
			$user->head_pic_1 = $userInfo['figureurl_qq_1'];
			//以下为默认值
			$user->password = '';
			$user->height = 0;
			$user->weight = 0;
			$user->age = 0;
			$user->email = '';
			$user->mobile = '';
			$user->email_validated = 0;
			$user->mobile_validated = 0;
			$user->type = COMMON_USER;
			$user->dead_user_status = DEAD_USER_FREE;
			$user->coin = 0;
			$user->source = SOURCE_FROM_QQ;
			$user->register_time = Date('Y-m-d H:i:s');
		}
		$user->qq_openid = $open_id;
		$user->qq_accesstoken = $access_token['access_token'];
		$user->qq_accessexpire = $access_token['expires_in'] + time();

		$user->last_login_time = Date('Y-m-d H:i:s');
		$user->setScenario('qqLogin');
		if($user->save()) {
			$_SESSION['uid'] = $user->id;
			$_SESSION['nickname'] = $user->nickname;
			$_SESSION['sex'] = $user->sex;
			setcookie('uid', $user->id, 0, '/', DOMAIN);
			setcookie('shared_session', session_id(), 0, '/', MAIN_DOMAIN);
			$this->renderPartial('redirect', array('redirect_url' => str_replace('&amp;', '&', CHtml::encode($redirect_url))));
		}
		else {
			$this->renderPartial('error', array('code' => 100, 'msg' => json_encode($user->getErrors())));
		}
	}

	public function actionGetUserInfo() {
		if (!CUser::checkLogin()) {
			return ToolUtils::ajaxOut(200);
		}
		$userInfo = CUser::getInfoByUid($_COOKIE['uid']);
		if ($userInfo === false) {
			return ToolUtils::ajaxOut(201);
		}
		$room = Room::model()->find('mid=' . $userInfo['id']);
		if ($room) {
			$userInfo['rUrl'] = $this->createUrl('/room/index', array('rid' => $room['id']));
		}
		ToolUtils::ajaxOut(0, '', $userInfo);
	}

	public function actionGetPublicKey() {
		@session_start();
		if (isset($_SESSION['pubKey'])) {
			return ToolUtils::ajaxOut(0, '', $_SESSION['pubKey']);
		}
		$config = array(
		    "digest_alg" => "sha512",
		    "private_key_bits" => 4096,
		    "private_key_type" => OPENSSL_KEYTYPE_RSA,
		);
		    
		$res = openssl_pkey_new($config);

		openssl_pkey_export($res, $privKey);

		$pubKey = openssl_pkey_get_details($res);

		$_SESSION['privKey'] = $privKey;
		$_SESSION['pubKey'] = $pubKey['key'];

		ToolUtils::ajaxOut(0, '', $pubKey['key']);	
	}

	public function actionRegister() {
		@session_start();
		$form = new RegisterForm;
		$form->attributes = $_POST;
		openssl_private_decrypt(base64_decode($form->password), $password, $_SESSION['privKey']);
		openssl_private_decrypt(base64_decode($form->passwordRepeat), $passwordRepeat, $_SESSION['privKey']);
		$form->password = $password;
		$form->passwordRepeat = $passwordRepeat;
		if (!$form->validate()) {
		 	return ToolUtils::ajaxOut(300, '', $form->getErrors());			
		}

		$user = new User('register');
		$user->username = $form->username;
		$user->password = $form->password;
		$user->age = $form->age;
		$user->height = $form->age;
		$user->weight = $form->weight;
		//以下为默认值
		$user->nickname = $form->username;
		$user->sex = 0;
		$user->head_pic_1 = DEFAULT_HEAD_PIC;
		$user->email = '';
		$user->mobile = '';
		$user->qq_openid = '';
		$user->qq_accesstoken = '';
		$user->qq_accessexpire = 0;
		$user->source = SOURCE_FROM_SELF;
		$user->email_validated = 0;
		$user->mobile_validated = 0;
		$user->type = COMMON_USER;
		$user->dead_user_status = DEAD_USER_FREE;
		$user->coin = 0;
		$user->last_login_time = Date('Y-m-d H:i:s', time(0));
		$user->register_time = Date('Y-m-d H:i:s');

		if ($user->save()) {
			$_SESSION['uid'] = $user->id;
			$_SESSION['nickname'] = $user->username;
			$_SESSION['sex'] = $user->sex;
			setcookie('uid', $user->id, 0, '/', DOMAIN);
			setcookie('shared_session', session_id(), 0, '/', MAIN_DOMAIN);
			return ToolUtils::ajaxOut(0);	
		}
		else {
			return ToolUtils::ajaxOut(301, '', $user->getErrors());
		}
	}

	public function actionLogin() {
		@session_start();
		$form = new LoginForm;
		$form->attributes = $_POST;
		openssl_private_decrypt(base64_decode($form->password), $password, $_SESSION['privKey']);
		$form->password = $password;

		if (!$form->validate()) {
			return ToolUtils::ajaxOut(400, '', $form->getErrors());
		}
		$userIdentity = new UserIdentity($form->username, $form->password);
		if (!$userIdentity->authenticate()) {
			return ToolUtils::ajaxOut(401, '用户名或密码错误');
		}
		$user = $userIdentity->getUser();

		$_SESSION['uid'] = $user->id;
		$_SESSION['nickname'] = $user->username;
		$_SESSION['sex'] = $user->sex;
		setcookie('uid', $user->id, $form->remember ? (time() + Yii::app()->params['cookieExpire']) : 0, '/', DOMAIN);
		setcookie('shared_session', session_id(), $form->remember ? (time() + Yii::app()->params['cookieExpire']) : 0, '/', MAIN_DOMAIN);
		return ToolUtils::ajaxOut(0);			

	}

	public function actionCenter($page = 1) {
		$this->loginUrl = CUser::getQQLoginUrl();
		$limit = 10;
		if (!CUser::checkLogin()) {
			$userInfo = null;
		}
		else {
			$userInfo = CUser::getInfoByUid($_SESSION['uid']);
			$userInfo['consume'] = Consume::model()->recently(($page - 1)*$limit, $limit)->findAll('uid=:uid', array(':uid' => $_SESSION['uid']));
			$userInfo['consume_total'] = Consume::model()->count('uid=:uid', array(':uid' => $_SESSION['uid']));
		}
		$this->render('ucenter', array('userInfo' => $userInfo));
	}

	public function actionLogout($callback) {
		@session_start();
		session_destroy();
		setcookie('uid', 0, time() - 1, '/', DOMAIN);
		header('location:' . $callback);
	}


	public function actionGetSessionInfo($session_id) {
		session_id($session_id);
		@session_start();
		if (!isset($_SESSION['uid'])) {
			return ToolUtils::ajaxOut(500);			
		}
		$userInfo = CUser::getInfoByUid($_SESSION['uid']);
		ToolUtils::ajaxOut(0, '', $userInfo);
	}

	public function actionUploadPic() {
		if (!($uid = CUser::checkLogin())) {
			return ToolUtils::ajaxOut(600);
		}
		$file = CUploadedFile::getInstanceByName('file');
		if ($file) {
			$saveDir = 'upload/' . date('Y_m_d') . '/';
			if (!file_exists($saveDir)) {
			 	mkdir($saveDir, 0755, true);
			}

			$fileName = $uid . '_' . time() . '_tmp'  . '.' . ToolUtils::getFileExt($file->getName());

			$file->saveAs($saveDir . $fileName);

			ToolUtils::ajaxOut(0, '', array('url' => 'http://' . DOMAIN . '/' . $saveDir . $fileName));
		}
	}

	public function actionUploadCropHeadPic() {
		if (!($uid = CUser::checkLogin())) {
			return ToolUtils::ajaxOut(700);
		}
		session_commit();
		$urlStruct = parse_url($_POST['url']);
		$path = $urlStruct['path'];
		$file_path = WEB_ROOT . $path;
		$ext = strtolower(ToolUtils::getFileExt($path));
		switch ($ext) {
			case 'jpg' :
			case 'jpeg' :
				$image = imagecreatefromjpeg($file_path);
				break;
			case 'png' :
				$image = imagecreatefrompng($file_path);
				break;
			default :
				return ToolUtils::ajaxOut(701, 'file type error');
		}

		list($width, $height) = getimagesize($file_path);

		$dst_r = imageCreateTrueColor($_POST['dw'], $_POST['dh']);

		$ratX = $width/$_POST['w'];
		$ratY = $height/$_POST['h'];

		imagecopyresampled($dst_r, $image, 0, 0, $_POST['x'] * $ratX, $_POST['y'] * $ratY,
		$_POST['dw'], $_POST['dh'], $_POST['dw'] * $ratX, $_POST['dh'] * $ratY);

		$headPicPath = dirname($file_path) . '/head_' . $uid . '.jpg';
		imagejpeg($dst_r, $headPicPath, 90);

		$url = ToolUtils::getUrlFromPath($headPicPath);

		Yii::app()->db->createCommand("begin")->execute();

		User::model()->updateByPk($uid, array('head_pic_1' => $url));

		// unlink($file_path);
		//同步到论坛
		$curl = new Curl;
		$curl->setCookie('shared_session', $_COOKIE['shared_session'],  '.' . MAIN_DOMAIN);
		$json = $curl->post('http://bbs.' . MAIN_DOMAIN . '/usercenter/config/syncUserInfo', array('headPic' => $url));
		$ret = json_decode($json, true);
		if (!($ret && $ret['status'] == 1)) {
			return ToolUtils::ajaxOut(701, '同步数据出错', $json);
		}

		Yii::app()->db->createCommand("commit")->execute();

		ToolUtils::ajaxOut(0, '', array('url' => $url));

	}

	public function actionUploadReHeadPic($index) {
		if (!($uid = CUser::checkLogin())) {
			return ToolUtils::ajaxOut(700);
		}
		session_commit();

		$url = ToolUtils::getUrlFromPath('img/face' . $index . '_s1.jpg');

		Yii::app()->db->createCommand("begin")->execute();

		User::model()->updateByPk($uid, array('head_pic_1' => $url));

		//同步到论坛
		$curl = new Curl;
		$curl->setCookie('shared_session', $_COOKIE['shared_session'],  '.' . MAIN_DOMAIN);
		$json = $curl->post('http://bbs.' . MAIN_DOMAIN . '/usercenter/config/syncUserInfo', array('headPic' => $url));
		$ret = json_decode($json, true);
		if (!($ret && $ret['status'] == 1)) {
			return ToolUtils::ajaxOut(701, '同步数据出错', $json);
		}

		Yii::app()->db->createCommand("commit")->execute(); 

		ToolUtils::ajaxOut(0, '', array('url' => $url));

	}

	public function actionUpdateUserInfo($scene) {
		if (!($uid = CUser::checkLogin())) {
			return ToolUtils::ajaxOut(800);
		}
		session_commit();

		if ($scene != 'nickname' && $scene != 'password') {
			return ToolUtils::ajaxOut(801, '参数错误');
		}
		$form = new UserUpdateForm($scene);
		$form->attributes = $_POST;
		if (!$form->validate()) {
			return ToolUtils::ajaxOut(802, '参数不合法', $form->getErrors());
		}
		if ($scene == 'nickname') {
			$data['nickname'] = $form->nickname;
		}
		else if ($scene == 'password'){
			$data['password'] = $form->password;
		}

		Yii::app()->db->createCommand("begin")->execute();

		User::model()->updateByPk($uid, $data);
		//同步到论坛
		if ($scene == 'nickname') {
			$curl = new Curl;
			$curl->setCookie('shared_session', $_COOKIE['shared_session'],  '.' . MAIN_DOMAIN);
			$json = $curl->post('http://bbs.' . MAIN_DOMAIN . '/usercenter/config/syncUserInfo', array('nickname' => $form->nickname));
			$ret = json_decode($json, true);
			if (!($ret && $ret['status'] == 1)) {
				return ToolUtils::ajaxOut(803, '同步数据出错', $json);
			}
		}

		Yii::app()->db->createCommand("commit")->execute(); 

		ToolUtils::ajaxOut(0);
	}

	public function actionPassword() {
		$this->render('password');
	}

	public function actionUpdatePassword() {
		if (!($uid = CUser::checkLogin())) {
			return ToolUtils::ajaxOut(900, "用户未登录");
		}
		$form = new UserUpdateForm('password');
		$form->attributes = $_POST;
		openssl_private_decrypt(base64_decode($form->password), $password, $_SESSION['privKey']);
		openssl_private_decrypt(base64_decode($form->newPassword), $newPassword, $_SESSION['privKey']);
		openssl_private_decrypt(base64_decode($form->newPasswordRepeat), $newPasswordRepeat, $_SESSION['privKey']);
		$form->password = $password;
		$form->newPassword = $newPassword;
		$form->newPasswordRepeat = $newPasswordRepeat;
		if (!$form->validate()) {
			return ToolUtils::ajaxOut(901, '参数不合法', $form->getErrors());
		}

		$userIdentity = new UserIdentity(null, $form->password);
		if (!$userIdentity->authenticate()) {
			return ToolUtils::ajaxOut(902, '密码错误');
		}

		User::model()->updateByPk($uid, array('password' => $newPassword));

		ToolUtils::ajaxOut(0);
	}
}





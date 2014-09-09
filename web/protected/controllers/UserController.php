<?php

include dirname(__FILE__) . '/../../../lib/QQConnectAPI/qqConnectAPI.php';

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/index';
	public $loginUrl;
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

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
		$qc = new QC();

		$qc->set_callback_argv('http://' . Yii::app()->params['domain'] . '/user/QQCallback/', array('redirect_url' => $callback));
		header('Location: ' . $qc->get_login_url());
	}

	public function actionQQCallback($redirect_url) {
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
			@session_start();
			$_SESSION['uid'] = $user->id;
			$_SESSION['nickname'] = $user->nickname;
			$_SESSION['sex'] = $user->sex;
			setcookie('uid', $user->id, time() + Yii::app()->params['cookieExpire'], '/', Yii::app()->params['domain']);
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

	public function actionRegister() {
		$form = new RegisterForm;
		$form->attributes = $_POST;
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
			@session_start();
			$_SESSION['uid'] = $user->id;
			$_SESSION['nickname'] = $user->username;
			$_SESSION['sex'] = $user->sex;
			setcookie('uid', $user->id, time() + Yii::app()->params['cookieExpire'], '/', Yii::app()->params['domain']);
			return ToolUtils::ajaxOut(0);	
		}
		else {
			return ToolUtils::ajaxOut(301, '', $user->getErrors());
		}
	}

	public function actionLogin() {
		$form = new LoginForm;
		$form->attributes = $_POST;
		if (!$form->validate()) {
			return ToolUtils::ajaxOut(400, '', $form->getErrors());
		}
		if (!($user = User::model()->find('username=:username and password=:password', array(':username' => $form->username, ':password' => $form->password)))) {
			return ToolUtils::ajaxOut(401, '用户名或密码错误');
		}
		$_SESSION['uid'] = $user->id;
		$_SESSION['nickname'] = $user->username;
		$_SESSION['sex'] = $user->sex;
		setcookie('uid', $user->id, $form->remember ? (time() + Yii::app()->params['cookieExpire']) : 0, '/', Yii::app()->params['domain']);
		return ToolUtils::ajaxOut(0);			

	}

	public function actionCenter($page = 1) {
		$this->loginUrl =  CUser::getQQLoginUrl();
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

	public function actionLogout() {
		setcookie('uid', 0, time() - 1, '/', Yii::app()->params['domain']);
		unset($_SESSION['uid']);
		unset($_SESSION['nickname']);
		unset($_SESSION['sex']);
		header('location:/');
	}


}





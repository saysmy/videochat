<?php

include dirname(__FILE__) . '/../../../lib/QQConnectAPI/qqConnectAPI.php';

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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

	public function actionQQLogin($url) {
		$qc = new QC();

		$qc->set_callback_argv(array('r' => 'user/QQCallback', 'redirect_url' => $url));
	
		$qc->qq_login();
	}

	public function actionQQCallback($redirect_url) {
		$qc = new QC();
		$access_token = $qc->qq_callback();
		$open_id = $qc->get_openid();
		unset($qc);

		$qc = new QC();
		$userInfo = $qc->get_user_info();
		Yii::log(json_encode($access_token), CLogger::LEVEL_INFO);

		$user = User::model()->find('qq_openid=:open_id', array(':open_id' => $open_id));
		if($user === null) {//新用户
			$user = new User();
		}
		$user->setScenario('login');
		$user->nickname = $userInfo['nickname'] ? $userInfo['nickname'] : 'QQ用户';
		$user->sex = $userInfo['gender'] == '女' ? 2 : 1;
		$user->head_pic_1 = $userInfo['figureurl_qq_1'];
		$user->qq_openid = $open_id;
		$user->qq_accesstoken = $access_token['access_token'];
		$user->qq_accessexpire = $access_token['expires_in'] + time();
		$user->last_login_time = Date('Y-m-d H:i:s');
		if($user->save()) {
			@session_start();
			$_SESSION['uid'] = $user->id;
			$_SESSION['nickname'] = $user->nickname;
			$_SESSION['sex'] = $user->sex;
			setcookie('uid', $user->id, time() + Yii::app()->params['cookieExpire'], '/', Yii::app()->params['domain']);
			header('Location:' . $redirect_url);
			exit;
		}
		else {
			$this->render('error', array('code' => 100, 'msg' => json_encode($user->getErrors())));
		}
	}

	public function actionIndex() {

	}

	public function actionError() {

	}



}

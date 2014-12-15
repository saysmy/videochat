<?php

ini_set('include_path', ini_get('include_path') . ':' .dirname(__FILE__) . '/../../../lib/');
include 'Zend/Amf/Server.php';

class AmfController extends Controller
{
	public function actionIndex() {
		$server = new Zend_Amf_Server();
		$server->setClass('ChatService');
		$response = $server->handle();
		echo $response;
	}

	public function actionTestGetUserInfo($rid) {
		@session_start();
		$service = new ChatService;
		$ret = $service->getUserInfo(session_id(), $_SESSION['uid'], $rid);
		var_export($ret);
	}


	public function actionTestDispatchDeadUser() {
		$service = new ChatService;
		$users = $service->dispatchDeadUser();
		var_export($users);
	}

	public function actionTestSendGift($rid) {
		$service = new ChatService;
		$service->sendGift(1, '', 1, 1,1,1);
	}

	public function actionTestMsgFilter() {
		$service = new ChatService;
		var_export($service->msgFilter('', '', '', array('msg' => '1')));
	}
}
<?php

class RoomController extends CController
{

	public $layout='//layouts/room';

	public $moderatorUserInfo;

	public $room;

	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		// return array(
		// 	array(
		// 		'application.filters.LoginFilter',
		// 	),
		// );
	}

	public function actionIndex($rid)
	{
		session_start();
		$this->room = Room::model()->findByPk($rid);
		$this->moderatorUserInfo = CUser::getInfoByUid($this->room['mid']);
		$prop = $this->getProperty();

		$maxPropInfo = CRoom::getSendMaxPricePropInfo($rid);
		if ($maxPropInfo) {
			$fromUser = CUser::getInfoByUid($maxPropInfo['from']);
			$toUser = CUser::getInfoByUid($maxPropInfo['to']);
			$maxPropInfo['fromNickname'] = $fromUser['nickname'];
			$maxPropInfo['toNickname'] = $toUser['nickname'];
		}

		$this->render('roomContent', array('rid' => $rid, 'sid' => session_id(), 'uid' => CUser::checkLogin() ? $_COOKIE['uid'] : Yii::app()->params['unLoginUid'], 'mid' => $this->room['mid'], 'appname' => 'videochat/room_' . $rid, 'sip' => Yii::app()->params['fmsServer'], 'prop' => $prop, 'maxPropInfo' => $maxPropInfo));
	}

	private function getProperty() {
		$propRecords = Property::model()->findAll(array('order' => 'price'));
		$prop = array();
		foreach($propRecords as $propRecord) {
			$prop[] = array('id' => $propRecord['id'], 'imgPreview' => $propRecord['imgPreview'], 'img' => $propRecord['img'], 'name' => $propRecord['name'], 'price' => $propRecord['price']);
		}	
		return $prop;
	}

	// Uncomment the following methods and override them if needed
	/*
	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
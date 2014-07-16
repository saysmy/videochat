<?php

class RoomController extends CController
{

	public $layout='//layouts/room';

	public $moderatorUserInfo;

	public $room;

	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			array(
				'application.filters.LoginFilter',
			),
		);
	}

	public function actionIndex($rid)
	{
		$this->room = Room::model()->findByPk($rid);
		$this->moderatorUserInfo = CUser::getInfoByUid($this->room['mid']);
		$prop = $this->getProperty();

		$this->render('roomContent', array('rid' => $rid, 'sid' => session_id(), 'uid' => $_COOKIE['uid'], 'mid' => $this->room['mid'], 'appname' => 'moderatorRoom_' . $rid, 'sip' => '192.168.120.131', 'prop' => $prop));
	}

	private function getProperty() {
		$propRecords = Property::model()->findAll(array('order' => 'price'));
		$prop = array();
		foreach($propRecords as $propRecord) {
			$prop[] = array('propId' => $propRecord['id'], 'img' => $propRecord['img'], 'desc' => $propRecord['name']);
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
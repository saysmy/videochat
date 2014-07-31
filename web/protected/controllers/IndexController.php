<?php

class IndexController extends CController
{

	public $layout='//layouts/index';

	public $loginUrl;

	public $qqLoginDisplay;

	public $uInfoDisplay;

	public $uInfo;

	private $roomConfig = array(
		'category0' => array(1,2,3,4,5),
		'category1' => array(1,2,3,4,5,6,7,8),
		'category2' => array(9,10,11,12),
		'recommend' => array(13,14,15),
		'hot' => array(16,17,18)
	);

	public function filters() {
		return array(
		    array(
		        'COutputCache',
		        'duration'=>0,
		        'varyByParam'=>array('id'),
		    ),
		);
	}

	public function actionIndex() {
		if(isset($_COOKIE['uid']) && CUser::checkLogin($_COOKIE['uid'])) {
			$qqLoginDisplay = 'hidden';
			$uInfoDisplay = '';
			$this->uInfo = CUser::getInfoByUid($_COOKIE['uid']);
			if ($this->uInfo['type'] == 2) {
				$room = Room::model()->find('mid=' . $this->uInfo['id']);
				if ($room) {
					$this->uInfo['rid'] = $room['id'];
				}
			}
		}
		else {
			$qqLoginDisplay = '';
			$uInfoDisplay = 'hidden';
		}
		$this->loginUrl =  'http://' . Yii::app()->params['domain'] . '/?r=user/qqLogin&callback=' . urlencode('http://' . Yii::app()->params['domain'] . '/');
		$this->qqLoginDisplay = $qqLoginDisplay;
		$this->uInfoDisplay = $uInfoDisplay;

		$roomData = array();
		foreach($this->roomConfig as $k => $roomIds) {
			$roomData[$k] = Room::model()->findAllByPk($roomIds);
		}

		$this->render('indexContent', array('roomData' => $roomData, 'uInfo' => $this->uInfo));
	}


}

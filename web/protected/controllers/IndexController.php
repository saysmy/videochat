<?php

class IndexController extends CController
{

	public $layout='//layouts/common';

	public $loginUrl;

	private $roomIds = array(5, 2, 6);

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

		$this->loginUrl =  CUser::getQQLoginUrl();

		$roomArr = array();
		$rooms = Room::model()->findAllByPk($this->roomIds);
		foreach($rooms as $room) {
			$moderators[$room->id] = User::model()->findByPk($room->mid);
			$roomArr[$room->id] = $room;
		}


		$moderators[$room->id]['age'] = $moderators[$room->id]['age'] == 0 ? '??' : $moderators[$room->id]['age'];
		$moderators[$room->id]['weight'] = $moderators[$room->id]['weight'] == 0 ? '??' : $moderators[$room->id]['weight'];
		$moderators[$room->id]['height'] = $moderators[$room->id]['height'] == 0 ? '??' : $moderators[$room->id]['height'];

		$this->render('indexContent', array('rooms' => $roomArr, 'moderators' => $moderators, 'roomIds' => $this->roomIds));
	}

}

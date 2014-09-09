<?php

class IndexController extends CController
{

	public $layout='//layouts/index';

	public $loginUrl;

	private $roomIds = array(1, 2, 3);

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

		$rooms = Room::model()->findAllByPk($this->roomIds);
		foreach($rooms as &$room) {
			$moderators[$room->id] = User::model()->findByPk($room->mid);
		}

		$this->render('indexContent', array('rooms' => $rooms, 'moderators' => $moderators));
	}


}

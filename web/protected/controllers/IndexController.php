<?php

class IndexController extends CController
{

	public $layout='//layouts/common';

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

		$rooms = Room::model()->findAll(array('condition' => 'status!=-1', 'order' => 'rank desc'));

		foreach($rooms as $room) {
			$room->moderator['age'] = $room->moderator['age'] == 0 ? '??' : $room->moderator['age'];
			$room->moderator['weight'] = $room->moderator['weight'] == 0 ? '??' : $room->moderator['weight'];
			$room->moderator['height'] = $room->moderator['height'] == 0 ? '??' : $room->moderator['height'];
		}

		$uid = CUser::checkLogin();

		$liveRecords = Room::model()->findAll(array('condition' => 'status=1', 'order' => 'rank desc'));
		$liveRooms = array();
		foreach($liveRecords as $item) {
			$room = array();
			foreach($item->attributeLabels() as $key => $t) {
				$room[$key] = $item->$key;
			}
			$room['play_start_time'] = strtotime($room['play_start_time']);
			$room['play_end_time'] = strtotime($room['play_end_time']);
			$room['moderator'] = $item->moderator;

			$liveRooms[] = $room;
		}

		$loveRooms = array();
		if ($uid) {
			$records = LoveRoom::model()->findAll('uid=' . $uid);
			foreach($records as $record) {
				$loveRooms[] = $record->rid;
			}
		}

		$this->render('index', array('rooms' => $rooms, 'liveRooms' => $liveRooms, 'loveRooms' => $loveRooms));
	}

}

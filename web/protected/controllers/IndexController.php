<?php

class IndexController extends CController
{

	public $layout='//layouts/common';

	public function filters() {
		return array(
		    array(
		        'COutputCache',
		        'duration' => 0,
		        'varyByParam' => array('id'),
		    ),
		);
	}
    
	public function actionIndex() {

		//所有房间
		$rooms = Room::model()->findAll(array('condition' => 'status!=-1', 'order' => 'rank desc'));
		foreach($rooms as $room) {
			$room->moderator['age'] = $room->moderator['age'] == 0 ? '??' : $room->moderator['age'];
			$room->moderator['weight'] = $room->moderator['weight'] == 0 ? '??' : $room->moderator['weight'];
			$room->moderator['height'] = $room->moderator['height'] == 0 ? '??' : $room->moderator['height'];
		}

		$uid = CUser::checkLogin();

		//首页banner房间
		$liveRecords = Room::model()->findAll(array('condition' => 'status=1', 'order' => 'rank desc'));
		$liveRooms = array();
		foreach($liveRecords as $item) {
			$room = array();
			foreach($item->getAttributes() as $key => $t) {
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

		//肥皂浴室 多人主播房间
		$multiRooms = Room::model()->findAll(array('condition' => 'status=2', 'order' => 'rank desc'));

		$indexNews = include(CONFIG_DIR . 'indexNews.php');

		$this->render('index', array(
				'rooms' => $rooms, 
				'liveRooms' => $liveRooms,
				'multiRooms' => $multiRooms,
				'loveRooms' => $loveRooms,
				'indexNews' => $indexNews,
			)
		);
	}

	public function actionGetRoomPublishInfo() {
		$rids = Yii::app()->request->getParam('rids');
		$roomInfo = array();
		foreach($rids as $rid) {
			$online_num = CRoom::getOnlineNum($rid);
			$publish_mid = CRoom::getPublishMid($rid);
			$nickname = null;
			if ($publish_mid != ROOM_PUB_NOBODY_UID) {
				$user = User::model()->find('id=' . $publish_mid);
				if ($user) {
					$nickname =	$user->nickname;
				}			
			}
			$roomInfo[$rid] = array('online_num' => $online_num, 'nickname' => $nickname, 'publish_mid' => $publish_mid);
		}

		ToolUtils::ajaxOut(0, '', $roomInfo);
	}

	public function actionOnlineRoomRedirect() {
		//所有房间
		$onlineRooms = array();
		$rooms = Room::model()->findAll(array('condition' => 'status!=-1'));
		foreach($rooms as $room) {
			if (CRoom::isPlaying($room->id)) {
				$onlineRooms[] = $room->id;
			}
		}
		if ($onlineRooms) {
			header('Location:http://' . DOMAIN . $this->createUrl('/room/index', array('rid' => $onlineRooms[rand(0, count($onlineRooms) - 1)])));
		}
		else {
			header('Location:/');
		}
	}
}

<?php

class RoomController extends MyController
{

	public $layout='//layouts/room';

	public function filters()
	{
        return array(
            array(
                'application.filters.LoginFilter + love',
            ),
        );	
    }

	public function actionIndex($rid)
	{
		session_start();
		$this->room = Room::model()->findByPk($rid);
		$prop = $this->getProperty();

		$maxPropInfo = CRoom::getSendMaxPricePropInfo($rid);
		if ($maxPropInfo) {
			$fromUser = CUser::getInfoByUid($maxPropInfo['from']);
			$toUser = CUser::getInfoByUid($maxPropInfo['to']);
			$maxPropInfo['fromNickname'] = $fromUser['nickname'];
			$maxPropInfo['toNickname'] = $toUser['nickname'];
		}

		$uid = CUser::checkLogin();

		$type = UNLOGIN_USER;
		$vipLevel = COMMON_LEVEL_USER;

		$this->loveRooms = array();
		if ($uid) {
			$records = LoveRoom::model()->findAll('uid=' . $uid);
			foreach($records as $record) {
				$this->loveRooms[] = $record->rid;
			}

			$userInfo = CUser::getInfoByUid($uid, $rid);
			$type = $userInfo['type'];
			$vipLevel = $userInfo['vip_level'];
		}


		$this->render('roomContent', array('rid' => $rid, 'vipLevel' => $vipLevel ,'roomType' => $this->room->type, 'sid' => session_id(), 'uid' => CUser::checkLogin() ? $_COOKIE['uid'] : Yii::app()->params['unLoginUid'], 'type' => $type , 'mid' => $this->room['mid'], 'appname' => 'videochat/room_' . $rid, 'sip' => Yii::app()->params['fmsServer'], 'prop' => $prop, 'maxPropInfo' => $maxPropInfo));
	}

	public function actionLove($rid) {

		if (!ToolUtils::frequencyCheck('loveRoom', 0.5)) {
			return ToolUtils::ajaxOut(-200, '操作过于频繁');
		}

		$uid = CUser::checkLogin();

		$room = Room::model()->findByPk($rid);
		if (!$room) {
			return ToolUtils::ajaxOut(200, '房间不存在');
		}

		$record = LoveRoom::model()->find('uid=' . $uid . ' and rid=' . $rid);

		if (!$record) {
			$record = new LoveRoom;
			$record->uid = $uid;
			$record->rid = $rid;
			$record->add_time = Date('Y-m-d H:i:s');
			if ($record->save()) {
				$room->love_num ++;
				$room->update();
				return ToolUtils::ajaxOut(0, '关注成功', array('action' => 'love'));
			}
			else {
				return ToolUtils::ajaxOut(100, '关注失败');
			}
		}
		else {
			$record->delete();
			$room->love_num --;
			$room->update();
			return ToolUtils::ajaxOut(0, '取消关注成功', array('action' => 'cancel'));
		}
	}

	private function getProperty() {
		$propRecords = Property::model()->findAll(array('order' => 'price'));
		$prop = array();
		foreach($propRecords as $propRecord) {
			$prop[] = array('id' => $propRecord['id'], 'imgPreview' => $propRecord['imgPreview'], 'img' => $propRecord['img'], 'name' => $propRecord['name'], 'price' => $propRecord['price']);
		}	
		return $prop;
	}
}
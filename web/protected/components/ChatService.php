<?php
class ChatService {
	public function getUserInfo($sid, $uid, $rid) {
		if(CUser::checkLogin($sid, $uid)) {
			return array('errno' => 100, 'msg' => 'not login');
		}

		$userInfo = CUser::getInfoByUid($uid);
		if($userInfo === false) {
			return array('errno' => 101, 'msg' => 'getUserInfo error:' . CUser::getError());
		}
		$userInfo['headPic'] = $userInfo['head_pic_1'];
		$userInfo['role'] = $userInfo['type'];
		$userInfo['loginMsg'] = '';
		$userInfo['logoutMsg'] = '';
		$userInfo['allowIn'] = true;

		$room = Room::model()->findByPk($rid);
		if(!$room) {
			return array('errno' => 102, 'msg' => 'get room info error rid:' . $rid);
		}
		$userInfo['roomMaxUser'] = $room['max_user'];

		return array('errno' => 0, 'msg' => '', 'data' => $userInfo);
	}

	public function sendGift($sid, $uid, $to, $propId, $count) {
		if(CUser::checkLogin($sid, $uid)) {
			return array('errno' => 201, 'msg' => 'not login');
		}
		$userInfo = CUser::getInfoByUid($uid);
		if($userInfo === false) {
			return array('errno' => 202, 'msg' => 'getUserInfo error:' . CUser::getError());
		}
		$prop = Property::model()->findByPk($propId);
		$rest = $userInfo['coin'] - $prop['price'] * $count;
		if ($rest < 0) {
			return array('errno' => 203, 'msg' => 'coin not enough');
		}
		User::model()->updateByPk($userInfo['id'], array('coin' => $rest));
		return array('errno' => 0, 'msg' => '', 'data' => array('propId' => $propId, 'propName' => $prop['name'], 'propPic' => $prop['img'], 'count' => $count));
	}
}
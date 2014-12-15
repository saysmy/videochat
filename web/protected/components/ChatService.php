<?php
class ChatService {
	public function getUserInfo($sid, $uid, $rid) {
		if(!CUser::checkLogin($uid, $sid)) {
			return array('errno' => NOT_LOGIN_ERR, 'msg' => 'not login');
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

	public function getRoomInfo($rid) {
		Yii::log('getRoomInfo rid:' . $rid);
		$room = Room::model()->findByPk($rid);
		if (!$room) {
			return array('errno' => 300, 'msg' => 'room not exits rid:' . $rid);
		}
		$ret = array();
		foreach($room->attributeLabels() as $col => $v) {
			$ret[$col] = $room->$col;
		}
		return array('errno' => 0, 'msg' => '', 'data' => $ret);
	}

	public function sendGift($rid, $sid, $uid, $to, $propId, $count) {
		if(!CUser::checkLogin($uid, $sid)) {
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
		$showProp = false;
		$roomPropMaxInfo = CRoom::getSendMaxPricePropInfo($rid);
		if ($prop['price'] * $count > PROP_SHOW_MIN_PRICE  && (!$roomPropMaxInfo || $prop['price'] * $count > $roomPropMaxInfo['price'])) {
			CRoom::setSendMaxPricePropInfo($rid, array(
					'from' => $uid, 
					'to' => $to, 
					'propId' => $propId, 
					'propName' => $prop['name'], 
					'propPic' => $prop['img'] , 
					'count' => $count, 
					'price' => $prop['price'] * $count,
					'time' => time(),
				)
			);
			$showProp = true;
		}
		$consume = new Consume;
		$consume->attributes = array(
			'uid' => $uid,
			'mid' => $to,
			'pid' => $propId,
			'pnum' => $count,
			'cost' => $prop['price'] * $count,
			'time' => date('Y-m-d H:i:s'),
		);
		if (!$consume->save()) {
			return array('errno' => 204, 'msg' => json_encode($consume->getErrors()));
		}
		User::model()->updateByPk($userInfo['id'], array('coin' => $rest));
		return array('errno' => 0, 'msg' => '', 'data' => array('propId' => $propId, 'propName' => $prop['name'], 'propPic' => $prop['img'], 'count' => $count, 'showProp' => $showProp, 'time' => time()));
	}

	public function dispatchDeadUser($rid) {
		Yii::app()->db->createCommand("begin")->execute(); 
		$users = Yii::app()->db->createCommand('select * from user where type=' . DEAD_USER . ' and dead_user_status=' . DEAD_USER_FREE . ' limit ' . rand(40, 50) . ' for update')->queryAll();
		if (!$users) {
			Yii::app()->db->createCommand("commit")->execute();
			return array('errno' => 0, 'msg' => '', 'data' => array());
		}
		foreach ($users as &$user) {
			$user_ids[] = $user['id'];
			$user['uid'] = $user['id'];
			$user['headPic'] = $user['head_pic_1'];
			$user['role'] = $user['type'];
			$user['loginMsg'] = '';
			$user['logoutMsg'] = '';
			$user['allowIn'] = true;
			unset($user['id']);
		}
		Yii::app()->db->createCommand('update user set dead_user_status=' . DEAD_USER_IN_USE . ' where id in(' . substr(json_encode($user_ids), 1, -1) . ')')->execute();
		Yii::app()->db->createCommand("commit")->execute();

		Yii::log('room:' . $rid . ' dispatchDeadUser:' . json_encode($user_ids), CLogger::LEVEL_INFO, 'chatService');

		return array('errno' => 0, 'msg' => '', 'data' => $users);
	}

	public function returnDeadUser($rid, $userIds) {
		Yii::log('room:' . $rid . ' return dead user:' . json_encode($userIds), CLogger::LEVEL_INFO, 'chatService');

		if (!$userIds) {
			return array('errno' => 400, 'msg' => 'userIds empty');
		}

		Yii::app()->db->createCommand('update user set dead_user_status=' . DEAD_USER_FREE . ' where id in(' . substr(json_encode($userIds), 1, -1) . ')')->execute();
		
		return array('errno' => 0);
	}

	public function msgFilter($sid, $uid, $rid, $msg) {
		if(!CUser::checkLogin($uid, $sid)) {
			return array('errno' => NOT_LOGIN_ERR, 'msg' => 'not login');
		}
		//禁言控制
		$ban_key = 'ban_' . $rid . '_' . $uid;
		if (Yii::app()->cache->get($ban_key)) {
			return array('errno' => 502);
		}

		//发言频率控制
		if (!ToolUtils::frequencyCheck('chat_' . $uid, 1)) {
			return array('errno' => 500);
		}

		//2s内不能发相同内容
		$msg_cache_key = 'chat_msg_' . $uid;
		if (($last_msg = Yii::app()->cache->get($msg_cache_key)) && $last_msg == $msg) {
			if (!ToolUtils::frequencyCheck('chat_' . $uid, 2)) {
				return array('errno' => 501);
			}
		}
		Yii::app()->cache->set($msg_cache_key, $msg);	

		$msg = CRoom::dirtyFilter($msg);

		return array('errno' => 0, 'msg' => '', 'data' => array('msg' => $msg));
	}

	public function ban($sid, $uid, $rid, $buid, $expire) {
		if(!CUser::checkLogin($uid, $sid)) {
			return array('errno' => NOT_LOGIN_ERR, 'msg' => 'not login');
		}

		$userInfo = CUser::getUserInfoByUid($uid);
		if (!$userInfo) {
			return array('errno' => 600);
		}

		if ($userInfo['type'] != ADMIN_USER) {
			return array('errno' => 601);
		}

		Yii::app()->cache->set('ban_' . $rid . '_' . $buid, 'true', $expire);

		return array('errno' => 0);

	}	




}
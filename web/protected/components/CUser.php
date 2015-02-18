<?php
class CUser {
	static public $errCode = 0;
	static public $errMsg = '';
	static public function getInfoByUid($uid, $rid = null) {
		$user = new User;
		$record = $user->findByPk($uid);
		if(!$record) {
			self::$errCode = 100;
			self::$errMsg = 'usr not found uid' . $uid;
			return false;
		}
		$ret = $record->getAttributes();
		if (strtotime($ret['vip_start']) <= time() && strtotime($ret['vip_end']) >= time()) {
			$ret['vip_level'] = VIP_LEVEL_USER;
		}
		else {
			$ret['vip_level'] = COMMON_LEVEL_USER;
		}
		if ($rid) {
			if(Yii::app()->cache->get('ban_' . $rid . '_'. $uid)) {
				$ret['ban'] = true;
			}
			else {
				$ret['ban'] = false;
			}

			$ret['type'] = COMMON_USER;

			$room = Room::model()->findByPk($rid);
			if ($room) {
				$admins = json_decode($room->admin, true);
				if ($admins && in_array($uid, $admins)) {
					$ret['type'] = ADMIN_USER;
				}

				$mids = json_decode($room->mids, true);
				if ($mids && in_array($uid, $mids)) {
					$ret['type'] = MODERATOR_USER;
				}
				
				if ($room->mid == $uid) {
					$ret['type'] = ROOM_OWN_USER;
				}
			}
			else {
				Yii::log('get room error rid:' . $rid, CLogger::LEVEL_ERROR);
			}

		}
		return $ret;
	}

	static public function banByUid($uid, $expire) {
		return Yii::app()->cache->set('ban_' . $uid, '1', $expire);
	}

	static public function checkLogin($uid = null, $sid = null) {
		if ($sid) {
			session_id($sid);
		}
		@session_start();
		if (!$uid) {
			if (!isset($_COOKIE['uid'])) {
				return false;
			}
			$uid = $_COOKIE['uid'];
		}
		if(!isset($_SESSION['uid']) || $_SESSION['uid'] != $uid) {
			return false;
		}
		return $uid;		
	}

	static public function getQQLoginUrl($callback = '') {
		return 'http://' . DOMAIN . '/user/qqLogin/?callback=' . urlencode($callback);
	}

	static private function getError() {
		return self::$errCode . '|' . self::$errMsg;
	}
}
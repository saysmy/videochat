<?php
class CUser {
	static public $errCode = 0;
	static public $errMsg = '';
	static public function getInfoByUid($uid) {
		$user = new User;
		$record = $user->find('id=' . $uid);
		if(!$record) {
			self::$errCode = 100;
			self::$errMsg = 'usr not found uid' . $uid;
			return false;
		}
		$ret = self::getBaseInfoByRecord($record);
		if(Yii::app()->cache->get('ban_' . $uid)) {
			$ret['ban'] = true;
		}
		else {
			$ret['ban'] = false;
		}
		return $ret;
	}

	static public function banByUid($uid, $expire) {
		return Yii::app()->cache->set('ban_' . $uid, '1', $expire);
	}

	static public function checkLogin($uid = null, $sid = null) {
		@session_start();
		if ($sid) {
			session_id($sid);
		}
		if (!$uid) {
			if (!isset($_COOKIE['uid'])) {
				return false;
			}
			$uid = $_COOKIE['uid'];
		}
		if(!isset($_SESSION['uid']) || $_SESSION['uid'] != $uid) {
			return false;
		}
		return true;		
	}

	static private function getBaseInfoByRecord($record) {
		$ret = array();
		foreach($record->attributeLabels() as $col => $v) {
			$ret[$col] = $record->$col;
		}
		return $ret;
	}

	static private function getError() {
		return self::$errCode . '|' . self::$errMsg;
	}
}
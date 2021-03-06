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

	static public function register($username, $password, $age, $weight, $height, &$error) {
		$user = new User('register');
		$user->username = $username;
		$user->password = $password;
		$user->age = $age;
		$user->height = $height;
		$user->weight = $weight;
		//以下为默认值
		$user->birthday = DEFAULT_BIRTHDAY;
		$user->nickname = $username;
		$user->true_name = '';
		$user->sex = 0;
		$user->head_pic_1 = DEFAULT_HEAD_PIC;
		$user->email = '';
		$user->mobile = '';
		$user->qq_openid = '';
		$user->qq_accesstoken = '';
		$user->qq_accessexpire = 0;
		$user->source = SOURCE_FROM_SELF;
		$user->email_validated = 0;
		$user->mobile_validated = 0;
		$user->type = COMMON_USER;
		$user->vip_start = DEFAULT_DATE;
		$user->vip_end = DEFAULT_DATE;
		$user->dead_user_status = DEAD_USER_FREE;
		$user->coin = NEW_USER_COIN;
		$user->last_login_time = DEFAULT_DATE;
		$user->register_time = Date('Y-m-d H:i:s');

		if ($user->save()) {
			return $user->id;
		}

		$error = $user->getErrors();

		return false;
	}

	static public function qqUserRegister($userInfo, $open_id, $access_token, $expires_in, $source) {

		$nickname = $userInfo['nickname'] ? $userInfo['nickname'] : 'QQ用户';

		$allUsers = User::model()->findAll('nickname like :nickname', array(':nickname' => $nickname . "%"));
		if ($allUsers) {
			$num = 0;
			foreach($allUsers as $tmpUser) {
				if ($tmpUser->nickname == $nickname) {
					$num = 1;
					continue;
				}
				if (!preg_match('/\(.*?\)$/i', $tmpUser->nickname, $matches)) {
					continue;
				}
				if (!is_numeric($matches[1])) {
					continue;
				}

				if($num <= (int)$matches[1]) {
					$num = (int)$matches[1] + 1;
				}
			}

			if ($num) {
				$nickname .= '(' . $num . ')';
			}
		}

		$user = new User('qqLogin');
		$user->username = QQ_LOGIN_PRE . $open_id;
		$user->nickname = $nickname;
		$user->sex = $userInfo['gender'] == '女' ? FEMALE_USER : MALE_USER;
		$user->head_pic_1 = $userInfo['figureurl_qq_1'];
		$user->qq_openid = $open_id;
		$user->qq_accesstoken = $access_token;
		$user->qq_accessexpire = $expires_in + time();
		$user->last_login_time = Date('Y-m-d H:i:s');
		//以下为默认值
		$user->birthday = DEFAULT_BIRTHDAY;
		$user->true_name = '';
		$user->password = '';
		$user->height = 0;
		$user->weight = 0;
		$user->age = 0;
		$user->email = '';
		$user->mobile = '';
		$user->email_validated = 0;
		$user->mobile_validated = 0;
		$user->type = COMMON_USER;
		$user->vip_start = DEFAULT_DATE;
		$user->vip_end = DEFAULT_DATE;
		$user->dead_user_status = DEAD_USER_FREE;
		$user->coin = NEW_USER_COIN;
		$user->source = $source;
		$user->register_time = Date('Y-m-d H:i:s');
		if (!$user->save()) {
			self::$errCode = 200;
			self::$errMsg = json_encode($user->getErrors());
			return false;
		}

		return $user->id;
	}

	static public function mobileRegister($mobile, $nickname, $sex, $password, &$error) {
		$user = new User('mobileRegister');
		$user->username = MOBILE_USERNAME_PRE . $mobile;
		$user->nickname = $nickname;
		$user->mobile = $mobile;
		$user->password = $password;
		$user->sex = $sex;
		
		//以下为默认值
		$user->birthday = DEFAULT_BIRTHDAY;		
		$user->head_pic_1 = DEFAULT_HEAD_PIC;
		$user->qq_openid = '';
		$user->qq_accesstoken = '';
		$user->qq_accessexpire = 0;
		$user->last_login_time = DEFAULT_DATE;
		$user->true_name = '';
		$user->height = 0;
		$user->weight = 0;
		$user->age = 0;
		$user->email = '';
		$user->email_validated = 0;
		$user->mobile_validated = 1;
		$user->type = COMMON_USER;
		$user->vip_start = DEFAULT_DATE;
		$user->vip_end = DEFAULT_DATE;
		$user->dead_user_status = DEAD_USER_FREE;
		$user->coin = NEW_USER_COIN;
		$user->source = SOURCE_FROM_APP;
		$user->register_time = Date('Y-m-d H:i:s');
		if ($user->save()) {
			return true;
		}

		$error = $user->getErrors();

		return $user->id;
	}

	static public function isVip($vip_start, $vip_end) {
	    if (strtotime($vip_start) <= time() && strtotime($vip_end) >= time()) {
	        return true;
	    }
	    else {
	        return false;
	    }		
	}	

	static public function getError() {
		return self::$errCode . '|' . self::$errMsg;
	}
}
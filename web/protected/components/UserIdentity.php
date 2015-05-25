<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */

	private $_user = null;

	public function __construct($username, $password) {
		parent::__construct($username, $password);
	}

	public function authenticate() {
		if ($this->username && $this->password) {
			if (!($this->_user = User::model()->find('(username=:username or mobile=:mobile) and password=:password', array(':username' => $this->username, ':password' => $this->password, ':mobile' => $this->username)))) {
				return false;
			}		
		}
		else if ($this->password) {
			if ($uid = CUser::checkLogin()) {
				if (!($this->_user = User::model()->findByPk($uid, 'password=:password', array(':password' => $this->password)))) {
					return false;
				}
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
		return true;

	}

	public function getUser() {
		return $this->_user;
	}
}
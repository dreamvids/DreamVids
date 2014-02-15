<?php

require_once SYSTEM.'Model.php';
require_once APP.'classes/User.php';
require_once APP.'classes/Users_session.php';

class Login_model extends Model {

	public function userExists($username) {
		return User::exists(array('username' => $username));
	}

	public function getPassForUsername($username) {
		return User::find_by_username($username)->pass;
	}

	public function connect($username, $remember) {
		if($this->userExists($username)) {
			$sessid = md5(uniqid());
			$expiration = ($remember) ? Utils::tps() + 365*86400 : Utils::tps() + 24*3600;
			$user = User::find_by_username($username);

			Users_session::create(array('user_id' => $user->id, 'session_id' => $sessid, 'expiration' => $expiration, 'remember' => $remember));
			setcookie('SESSID', $sessid, $expiration);
		}
	}

	public function logout($userId) {
		Users_session::delete_all(array('conditions' => array('user_id = ?', $userId)));
		setcookie("SESSID", '', -1);
		Session::set(-1);
	}

}
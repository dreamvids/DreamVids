<?php

require_once APP.'classes/Users_session.php';
require_once APP.'classes/LoggedUser.php';

class Session {

	private static $session = -1;

	public static function init() {
		if(isset($_COOKIE['SESSID'])) {
			if(Users_session::exists(array('session_id' => $_COOKIE['SESSID']))) {
				//$session = new LoggedUser(Users_session::find_by_session_id($_COOKIE['SESSID'])->user_id, $_COOKIE['SESSID']);
				$session = User::find_by_id(Users_session::find_by_session_id($_COOKIE['SESSID'])->user_id);
				self::set($session);
			}
			else {
				setcookie("SESSID", "", -1);
				self::set(-1);
			}
		}

		Users_session::delete_all(array('conditions' => array('expiration < ?', Utils::tps())));
	}

	public static function set($session) {
		self::$session = $session;
	}

	public static function get() {
		return self::$session;
	}

	public static function isActive() {
		return is_object(self::$session);
	}

}
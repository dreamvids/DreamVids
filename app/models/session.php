<?php

require_once MODEL.'user.php';
require_once MODEL.'user_session.php';

class Session {

	private static $session = -1;

	public static function init() {
		/*var_dump($_COOKIE);
		var_dump(get_class((Object)self::$session));
		echo '-------------------';*/
		if(isset($_COOKIE['SESSID'])) {
			if(UserSession::exists(array('session_id' => $_COOKIE['SESSID']))) {
				$session = User::find_by_id(UserSession::find_by_session_id($_COOKIE['SESSID'])->user_id);
				session_id($_COOKIE['SESSID']);
				
				self::set($session);
			}
			else {
				setcookie("SESSID", "", -1);
				self::set(-1);
			}
	 	session_start();
		}
		/*var_dump($_COOKIE);
		var_dump(get_class((Object)self::$session));
		echo '-------------------';*/
		UserSession::delete_all(array('conditions' => array('expiration < ?', Utils::tps())));
	}

	public static function set($session) {
		self::$session = $session;
	}
	/**
	 * @return User
	 */
	public static function get() {
		return self::$session;
	}

	public static function getId() {
		return $_COOKIE['SESSID'];
	}

	public static function isActive() {
		return is_object(self::$session);
	}

}

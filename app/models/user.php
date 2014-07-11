<?php

require_once MODEL.'user_channel.php';
require_once MODEL.'user_session.php';

class User extends ActiveRecord\Model {

	public function getMainChannel() {
		return UserChannel::find_by_name($this->username);
	}

	public function getOwnedChannels() {
		return UserChannel::all(array('conditions' => array('admins_ids LIKE ?', $this->id.';%')));
	}

	public function getPostedVideos() {
		$videos = array();
		$channels = $this->getOwnedChannels();

		foreach($channels as $channel)
			foreach($channel->getPostedVideos() as $vid) $videos[] = $vid;

		return $videos;
	}

	public function getPassword() {
		return $this->pass;
	}

	public static function getNameById($userId) {
		return User::find_by_id($userId)->username;
	}

	public static function getIdByName($username) {
		return User::find_by_username($username)->id;
	}

	public static function isMailRegistered($mail) {
		return User::exists(array('email' => $mail));
	}

	public static function register($username, $password, $mail) {
		$appConfig = new Config(CONFIG.'app.json');
		$appConfig->parseFile();

		$userRank = $appConfig->getValue('rankUser');

		User::create(array(
			'username' => $username,
			'email' => $mail,
			'pass' => sha1($password),
			'followings' => '',
			'subscriptions' => '',
			'reg_timestamp' => Utils::tps(),
			'reg_ip' => $_SERVER['REMOTE_ADDR'],
			'actual_ip' => $_SERVER['REMOTE_ADDR'],
			'rank' => $userRank
		));

		UserChannel::create(array(
			'id' => UserChannel::generateId(6),
			'name' => $username,
			'description' => '',
			'owner_id' => User::getIdByName($username),
			'admins_ids' => User::getIdByName($username).';',
			'subscribers' => 0,
			'views' => 0
		));
	}

	public static function connect($username, $remember) {
		if(User::find_by_username($username)) {
			$sessid = md5(uniqid());
			$expiration = ($remember) ? Utils::tps() + 365*86400 : Utils::tps() + 24*3600;
			$user = User::find_by_username($username);

			UserSession::create(array('user_id' => $user->id, 'session_id' => $sessid, 'expiration' => $expiration, 'remember' => $remember));
			setcookie('SESSID', $sessid, $expiration);
		}
	}

	public static function logoutCurrent() {
		if(Session::isActive()) {
			UserSession::delete_all(array('conditions' => array('user_id = ?', Session::get()->id)));
			setcookie("SESSID", '', -1);
			Session::set(-1);
		}
	}

}
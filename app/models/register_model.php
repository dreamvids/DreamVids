<?php

require_once SYSTEM.'Model.php';
require_once APP.'classes/User.php';

class Register_model extends Model {

	public function userExists($username) {
		return User::exists(array('username' => $username));
	}

	public function mailRegistered($mail) {
		return User::exists(array('email' => $mail));
	}

	public function register($username, $password, $mail) {
		User::create(array(
			'username' => $username,
			'email' => $mail,
			'pass' => sha1($password),
			'avatar' => '',
			'background' => '',
			'followers' => 0,
			'followings' => '',
			'subscriptions' => '',
			'reg_timestamp' => Utils::tps(),
			'reg_ip' => $_SERVER['REMOTE_ADDR'],
			'actual_ip' => $_SERVER['REMOTE_ADDR'],
			'rank' => $config['rank_user']
		));
	}
}
<?php

require_once SYSTEM.'Model.php';
require_once APP.'classes/User.php';
require_once APP.'classes/UserChannel.php';

class Register_model extends Model {

	public function userExists($username) {
		return User::exists(array('username' => $username));
	}

	public function mailRegistered($mail) {
		return User::exists(array('email' => $mail));
	}

	public function register($username, $password, $mail) {
		global $config;
		User::create(array(
			'username' => $username,
			'email' => $mail,
			'pass' => sha1($password),
			'followings' => '',
			'subscriptions' => '',
			'reg_timestamp' => Utils::tps(),
			'reg_ip' => $_SERVER['REMOTE_ADDR'],
			'actual_ip' => $_SERVER['REMOTE_ADDR'],
			'rank' => $config['rank_user']
		));

		UserChannel::create(array(
			'id' => UserChannel::generateId(6),
			'name' => $username,
			'description' => '',
			'owner_id' => User::getIdByName($username),
			'admins_ids' => User::getIdByName($username),
			'subscribers' => 0,
			'views' => 0
		));
	}
}
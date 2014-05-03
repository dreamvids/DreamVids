<?php

class User extends ActiveRecord\Model {

	public function getMainChannel() {
		return UserChannel::find_by_name($this->username);
	}

	public static function getNameById($userId) {
		return User::find_by_id($userId)->username;
	}

	public static function getIdByName($username) {
		return User::find_by_username($username)->id;
	}

}
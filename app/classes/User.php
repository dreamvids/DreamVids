<?php

class User extends ActiveRecord\Model {

	public static function getNameById($userId) {
		return User::find_by_id($userId)->username;
	}

}
<?php

require_once SYSTEM.'Model.php';
require_once APP.'classes/User.php';

class Profile_model extends Model {
	
	public function getUserPassword($userId) {
		return User::find_by_id($userId)->pass;
	}

	public function setPassword($userId, $newPassword) {
		$user = User::find_by_id($userId);
		$user->pass = $newPassword;
		$user->save();
	}

}
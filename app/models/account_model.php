<?php

require_once SYSTEM.'Model.php';
require_once APP.'classes/User.php';
require_once APP.'classes/Video.php';
require_once APP.'classes/MultiUserChannel.php';

class Account_model extends Model {
	
	public function getUserPassword($userId) {
		return User::find_by_id($userId)->pass;
	}

	public function setPassword($userId, $newPassword) {
		$user = User::find_by_id($userId);
		$user->pass = $newPassword;
		$user->save();
	}

	public function getVideosFromUser($userId) {
		return Video::all(array('poster_id' => $userId));
	}

	public function getChannelsOwnedByUser($userId) {
		$channels = array();

		$channels = MultiUserChannel::all();

		return $channels;
	}
}
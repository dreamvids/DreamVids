<?php

require_once SYSTEM.'Model.php';
require_once APP.'classes/User.php';
require_once APP.'classes/Video.php';
require_once APP.'classes/UserChannel.php';

class Account_model extends Model {
	
	public function getUserPassword($userId) {
		return User::find_by_id($userId)->pass;
	}

	public function getUserMail($userId) {
		return User::find_by_id($userId)->email;
	}

	public function setPassword($userId, $newPassword) {
		$user = User::find_by_id($userId);
		$user->pass = $newPassword;
		$user->save();
	}

	public function setMail($userId, $newMail) {
		$user = User::find_by_id($userId);
		$user->email = $newMail;
		$user->save();
	}

	public function setUserAvatar($userId, $newAvatar) {
		$user = User::find_by_id($userId);
		$user->avatar = $newAvatar;
		$user->save();
	}

	public function setUserBackground($userId, $newBackground) {
		$user = User::find_by_id($userId);
		$user->background = $newBackground;
		$user->save();
	}

	public function setUsername($userId, $newUsername) {
		$user = User::find_by_id($userId);
		$user->username = $newUsername;
		$user->save();
	}

	public function getVideosFromUser($userId) {
		return Video::all(array('poster_id' => $userId));
	}

	public function getChannelsOwnedByUser($userId) {
		$channels = array();

		$channels = UserChannel::all(array('owner_id' => $userId));

		return $channels;
	}
}
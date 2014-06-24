<?php

// Used for multi-user channels
class UserChannel extends ActiveRecord\Model {

	static $table_name = 'users_channels';

	public function getPostedVideos() {
		return Video::all(array('conditions' => array('poster_id' => $this->id)));
	}

	public function belongToUser($userId) {
		if(User::exists($userId)) {
			$ownedChannels = User::find($userId)->getOwnedChannels();

			if(in_array($this, $ownedChannels))
				return true;
			else
				return false;
		}
		else
			return false;
	}

	public function isUsersMainChannel($userId) {
		if(User::exists($userId)) {
			$user = User::find($userId);
			return $user->getMainChannel()->id == $this->id;
		}
		else
			return false;
	}

	public static function generateId($length) {
		$idExists = true;

		while($idExists) {
			$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$id = '';
		
			for ($i = 0; $i < $length - 2; $i++) {
				$id .= $chars[rand(0, strlen($chars) - 1)];
			}

			$id = 'c_'.$id;

			$idExists = UserChannel::exists(array('id' => $id));
		}

		return $id;
	}

	public static function getNameById($channelId) {
		return UserChannel::find_by_id($channelId)->name;
	}

}
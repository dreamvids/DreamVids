<?php

class LiveAccess extends ActiveRecord\Model {

	static $table_name = 'live_accesses';

	public function isOnline() {
		return $this->online;
	}

	public function getChannel() {
		return UserChannel::find($this->channel_id);
	}

	public static function grantedForUser($user) {
		return LiveAccess::exists(array('user_id' => $user->id));
	}
	
	public static function getOnlines() {
		return LiveAccess::all(array('conditions' => array('online' => 1)));
	}

}

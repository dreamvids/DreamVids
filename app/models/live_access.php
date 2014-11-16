<?php

class LiveAccess extends ActiveRecord\Model {

	static $table_name = 'live_accesses';

	public function isOnline() {
		return $this->online;
	}

	public static function grantedForUser($user) {
		foreach($user->getOwnedChannels() as $channel) {
			if(LiveAccess::exists(array('channel_id' => $channel->id)))
				return $channel;
		}

		return false;
	}

}

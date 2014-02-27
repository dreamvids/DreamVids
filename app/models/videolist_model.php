<?php

require_once SYSTEM.'Model.php';
require_once APP.'classes/Video.php';

class Videolist_model extends Model {

	public function getDiscoverVideos() {
		return Video::all(array('limit' => 10, 'order' => 'timestamp desc'));
	}

	public function userExists($userId) {
		return User::exists(array('id' => $userId));
	}

}
<?php

require_once SYSTEM.'Model.php';
require_once APP.'classes/Video.php';

class Member_model extends Model {

	public function getVideoesFromUser($userId) {
		if(User::exists(array('id' => $userId))) {
			return Video::find('all', array('conditions' => array('user_id = ?', $userId)));
		}
	}

}
<?php

require_once SYSTEM.'Model.php';
require_once APP.'classes/User.php';
require_once APP.'classes/Video.php';

class Admin_model extends Model {

	public function getReportedVideos($limit = 'nope') {
		if($limit != 'nope') {
			return Video::all(array('conditions' => array('flagged', 1), 'order' => 'timestamp desc', 'limit' => $limit));
		}
		else {
			return Video::all(array('conditions' => array('flagged', 1), 'order' => 'timestamp desc'));
		}
	}

	public function suspendVideo($videoId) {
		Video::update_all(array('conditions' => array('id' => $videoId), 'set' => array('visibility' => $GLOBALS['config']['vid_visibility_suspended'])));
	}

}
<?php

require_once SYSTEM.'Model.php';
require_once APP.'classes/User.php';
require_once APP.'classes/Video.php';

class Upload_model extends Model {

	public function createTempVideo($userId) {
		$videoId = Video::generateId(6);
		$_SESSION['VIDEO_UPLOAD_ID'] = $videoId;
		Video::createTemp($videoId, $userId);
	}

	public function updateTempURL($vidId, $newURL) {
		Video::updateURL($vidId, $newURL);
	}

	public function registerVideo($vidId, $userId, $title, $desc, $tags, $thumb, $timestamp, $visibility) {
		Video::register($vidId, $userId, $title, $desc, $tags, $thumb, $timestamp, $visibility);
		//$_SESSION['VIDEO_UPLOAD_ID'] = -1;
	}

}
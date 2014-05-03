<?php

require_once SYSTEM.'Model.php';
require_once APP.'classes/User.php';
require_once APP.'classes/Video.php';

class Upload_model extends Model {

	public function createTempVideo($channelId) {
		$videoId = Video::generateId(6);
		$_SESSION['VIDEO_UPLOAD_ID'] = $videoId;
		Video::createTemp($videoId, $channelId);
	}

	public function updateTempURL($vidId, $newURL) {
		Video::updateURL($vidId, $newURL);
	}

	public function registerVideo($vidId, $channelId, $title, $desc, $tags, $thumb, $timestamp, $visibility) {
		Video::register($vidId, $channelId, $title, $desc, $tags, $thumb, $timestamp, $visibility);
		//$_SESSION['VIDEO_UPLOAD_ID'] = -1;
	}

	public function setVideoThumbnail($vidId, $newThumb) {
		Video::update_all(array('conditions' => array('id' => $vidId), 'set' => array('tumbnail' => $newThumb)));
	}

}
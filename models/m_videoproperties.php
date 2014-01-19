<?php

require_once('./classes/Video.php');

class VideoProperties {

	public static function getVideoById($vidId) {
		return Video::get($vidId);
	}

}

?>
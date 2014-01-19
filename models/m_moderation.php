<?php

require_once('classes/User.php');

class Moderation {
	public static function getFlaggedVideos() {
		$flaggedVids = array();

		$db = new BDD();
		$res = $db->select("*", "videos", "WHERE flagged=1");

		while ($data = $db->fetch_array($res)) {
			$flaggedVids[] = Video::get($data['id']);
		}

		return $flaggedVids;
	}
}

?>
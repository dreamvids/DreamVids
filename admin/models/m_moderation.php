<?php
class AdminModeration {
	
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
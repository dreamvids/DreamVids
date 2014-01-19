<?php

class Manager {
	public static function getVideosFromUser($userId) {
		$user = new User($userId);
		if($user->getId() != -1) {
			$db = new BDD();
			$res = $db->select("id", "videos", "WHERE user_id='".$db->real_escape_string($user->getId() )."'");
			$vids = array();
			while ($data = $db->fetch_array($res) ) {
				$vids[] = Video::get($data['id']);
			}
			return $vids;
		}
	}
}

?>
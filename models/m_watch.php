<?php

class Watch {
	// moderator's action on the watch video page
	public static function isModerator($user) {
		return $user->getRank() >= $GLOBALS['config']['rank_modo']; // returns true is the user is moderator/admin
	}

	public static function suspendVideo($vidId) {
		$video = Video::get($vidId);
		$video->setVisibility(3); // 3 = suspended
		$video->saveDataToDatabase();
	}

	public static function unsuspendVideo($vidId) {
		$video = Video::get($vidId);
		$video->setVisibility(2); // 2 = publicw
		$video->saveDataToDatabase();
	}
	
	public static function isLiked($vid) {
		$db = new BDD();
		$data = $db->num_rows($db->select("user_id", "videos_votes", "WHERE user_id='".$GLOBALS['session']->getId()."' AND type='video' AND action='like' AND obj_id='".$db->real_escape_string($vid)."'") );
		return ($data > 0);
	}
	
	public static function isDisliked($vid) {
		$db = new BDD();
		$data = $db->num_rows($db->select("user_id", "videos_votes", "WHERE user_id='".$GLOBALS['session']->getId()."' AND type='video' AND action='dislike' AND obj_id='".$db->real_escape_string($vid)."'") );
		return ($data > 0);
	}

	public static function getComments($vidId) {
		$comments = array();
		$db = new BDD();
		$res = $db->select("*", "videos_comments", "WHERE video_id='".$vidId."' ORDER BY timestamp DESC");

		$i = 0;
		while($row = $db->fetch_array($res)) {
			$commId = $row['id'];
			$comments[$i] = Comment::get($commId);
			$i++;
		}

		return $comments;
	}

	public static function flagVideo($vid) {
		$vid->setFlagged(1);
		$vid->saveDataToDatabase();
	}

	public static function unflagVideo($vid) {
		$vid->setFlagged(0);
		$vid->saveDataToDatabase();
	}
}

?>
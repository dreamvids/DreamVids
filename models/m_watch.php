<?php

class Watch {
	// moderator's action on the watch video page
	public static function isModerator($user) {
		return $user->getRank() >= 1; // returns true is the user is moderator/admin
	}

	public static function suspendVideo($vidId) {
		$video = Video::get($vidId);
		$video->setVisibility(3); // 3 = suspended
		$video->saveDataToDatabase();
	}
}

?>
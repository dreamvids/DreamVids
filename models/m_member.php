<?php

class Member {

	public static function getVideosFromUsers($userId) {
		$vids = array();
		$db = new BDD();
		$res = $db->select('*', 'videos', 'WHERE user_id='.$userId);

		$i = 0;
		while($row = $db->fetch_array($res)) {
			$vids[$i] = Video::get($row['id']);
			$i++;
		}

		return $vids;
	}

}

?>

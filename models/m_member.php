<?php

class Member {

	public static function getVideosFromUsers($userId, $LIMIT="4") {
		$vids = array();
		$db = new BDD();
		//$res = $db->select('*', 'videos', 'WHERE user_id='.$userId.' ORDER BY timestamp DESC LIMIT 0,'.$LIMIT);
		$res = $db->select('*', 'videos', 'WHERE user_id='.$userId.' ORDER BY timestamp DESC');

		$i = 0;
		while($row = $db->fetch_array($res)) {
			$vid = Video::get($row['id']);

			if($vid->getVisibility() == 2) {
				$vids[$i] = $vid;
				$i++;
			}
		}

		return $vids;
	}
}

?>

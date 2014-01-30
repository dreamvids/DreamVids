<?php

class Member {

	public static function getVideosFromUsers($userId, $LIMIT="0") {
		$vids = array();
		$db = new BDD();
		if ($LIMIT = '0') {
			$enplus = 'WHERE user_id='.$userId.' ORDER BY timestamp DESC LIMIT 0,5';
		}else{
			$enplus = 'WHERE user_id='.$userId.' ORDER BY timestamp DESC LIMIT 0,500';
		}
		$res = $db->select('*', 'videos', $enplus);

		$i = 0;
		while($row = $db->fetch_array($res)) {
			$vids[$i] = Video::get($row['id']);
			$i++;
		}

		return $vids;
	}
}

?>

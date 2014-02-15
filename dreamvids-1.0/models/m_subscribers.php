<?php

class Subscribers {

	public static function getAll($userId) {
		$subs = array();

		$db = new BDD();
		$req = $db->select("*", "users", "WHERE id != ".$userId);

		$i = 0;
		while($row = $db->fetch_array($req)) {
			$userSubscriptions = explode(';', $row['subscriptions']);
			
			if(in_array($userId, $userSubscriptions)) {
				$subs[$i] = new User($row['id']);
				$i++;
			}
		}

		return $subs;
	}

}

?>
<?php

class Manager {
	public static function getVideosFromUser($userId) {
		$user = new User($userId);
		echo $user->getName().'<br>';
		if($user->getId() != -1) {
			$db = new BDD();
			$res = $db->query("SELECT * FROM videos WHERE user_id='".$user->getId()."'");
			$rows = $db->fetch_array($res);

			print_r($rows);
		}
		else echo "BAAAAAD";
	}
}

?>
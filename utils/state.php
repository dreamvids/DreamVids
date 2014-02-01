<?php
if ($_SERVER['argc'] = 3) {
	include '../includes/bdd.class.php';

	$video_id = $_SERVER['argv'][1];
	$db = new BDD();
	if ($_SERVER['argv'][2] == "sd") {
		$req = "sd=sd + 1";
	}elseif ($_SERVER['argv'][2] == "hd") {
		$req = "hd=hd + 1";
	}

	$db->update("videos_convert", $req, "WHERE video_id='".$video_id."'");
	$db->close();
}

?>
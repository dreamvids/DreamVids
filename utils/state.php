<?php
if ($_SERVER['argc'] = 3) {
	include '/home/www/DreamVids/includes/bdd.class.php';	
	
	$db = new BDD();
	/*$video_id =  basename($_SERVER['argv'][1], ".".end(explode('.', $_SERVER['argv'][1])));
	if ($_SERVER['argv'][2] == "sd") {
		$req = "sd=sd + 1";
	}elseif ($_SERVER['argv'][2] == "hd") {
		$req = "hd=hd + 1";
	}

	$db->update("videos_convert", $req, "WHERE video_id='".$video_id."'");*/
	$db->update("videos_convert", "sd='2', hd='2'", "WHERE sd='0'");
	$db->close();
}

?>
<?php

if(!isset($session)) {
	header("Location: ./");
	exit();
}

if(empty($vids)) {
	$err = $lang['error_no_videos_uploaded'];	
}

if(isset($_GET['delVid'])) {
	$vidToDelId = htmlentities(mysql_real_escape_string($_GET['delVid']));
	Manager::deleteVideo($vidToDelId, $session->getId());
}

$vids = Manager::getVideosFromUser($session->getId());
?>
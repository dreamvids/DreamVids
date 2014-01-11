<?php

if(!isset($session)) {
	header("Location: ./");
	exit();
}

$vids = Manager::getVideosFromUser($session->getId());
if(empty($vids)) {
	$err = "Vous n'avez pas encore publié de vidéos !";	
}

?>
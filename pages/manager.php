<?php

if(!isset($session)) {
	header("Location: ./");
	exit();
}

$vids = Manager::getVideosFromUser($session->getId());

?>
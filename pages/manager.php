<?php

if(!isset($session)) {
	header("Location: ./");
	exit();
}

echo "ssid: ".$session->getSessionId();
Manager::getVideosFromUser($session->getId());

?>
<?php
if(!isset($session)) {
	header('Location: /login');
	exit();
}

if(!in_array($session->getRank(), array($config['rank_adm'], $config['rank_modo']) ) ) {
	header('Location: ./');
	exit();
}

$title = 'Modération';
$subtitle = 'Vidéos signalées';
$flaggedVids = AdminModeration::getFlaggedVideos();
?>
<?php

if(isset($_GET['id']) xor isset($_GET['name'])) {
	$id = (isset($_GET['id']) ) ? $_GET['id'] : User::getIdByName($_GET['name']);
	$member = new User($id);
	$pseudo = $member->getName();
	if($pseudo) {
		if (isset($_GET['all'])) {
			$videos = Member::getVideosFromUsers($member->getId(),'500');
		}else{
			$videos = Member::getVideosFromUsers($member->getId());
		}
		$avatar = $member->getAvatarPath();
		$subscribers = $member->getSubscribers();
		$rank = $member->getRank();
	}
	else
		die('Erreur lors de l\'obtention du flux RSS de ce membre');
}
else {
	header("Location: ./");
}

?>
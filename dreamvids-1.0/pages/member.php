<?php

if(isset($_GET['uid']) xor isset($_GET['name'])) {
	$id = (isset($_GET['uid']) ) ? $_GET['uid'] : User::getIdByName($_GET['name']);
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
		die('Error occurred while loading the Member !');
}
else {
	header("Location: ./");
}

?>
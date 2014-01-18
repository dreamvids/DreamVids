<?php

if(isset($_GET['uid']) xor isset($_GET['name']) ) {
	$id = (isset($_GET['uid']) ) ? $_GET['uid'] : User::getIdByName($_GET['name']);
	$member = new User($id);
	$pseudo = $member->getName();
	if($pseudo) {
		$avatar = $member->getAvatarPath();
		$rank = $member->getRank();
		$vids = $member->getVids();
	}
	else
		die('Error occurred while loading the Member !');
}
else {
	header("Location: ./");
}

?>
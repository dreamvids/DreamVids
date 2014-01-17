<?php

if(isset($_GET['uid'])) {
	$member = new User($_GET['uid']);
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
<?php

if(isset($_GET['vid'])) {
	$video = Video::get(htmlentities($_GET['vid']));
	$title = $video->getTitle();
	if($title) {
		$id = $video->getId();
		$desc = $video->getDescription();
		$views = $video->getViews();
		$likes = $video->getLikes();
		$dislikes = $video->getDislikes();
		$path = $video->getPath();
		$tumbnail = $video->getTumbnail();
		$author = new User($video->getUserId() );
	}
	else
		die($lang['error_load_vid']);
}
else {
	header("Location: ./");
}

?>
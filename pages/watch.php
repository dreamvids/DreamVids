<?php

if(isset($_GET['vid'])) {
	$video = Video::get(htmlentities($_GET['vid']));
	$title = $video->getTitle();
	$id = $video->getId();
	$author = new User($video->getUserId());

	if($title) {
		if(!$video->isSuspended()) {
			$desc = $video->getDescription();
			$views = $video->getViews();
			$likes = $video->getLikes();
			$dislikes = $video->getDislikes();
			$path = $video->getPath();
			$tumbnail = $video->getTumbnail();

			if(isset($GLOBALS['session'])) {
				$isLiked = (Watch::isLiked($_GET['vid']) ) ? 'liked="liked"' : '';
				$isDisliked = (Watch::isDisliked($_GET['vid']) ) ? 'disliked="disliked"' : '';
			}
		}
		else {
			$err = $lang['video_suspended'];
		}
	}
	else
		die($lang['error_load_vid']);
}
else {
	header("Location: ./");
}

// modo's actions
if(isset($_POST['suspend_vid'])) {
	if(Watch::isModerator($session)) {
		$vid = Video::get(htmlentities($_GET['vid']));
		Watch::suspendVideo($vid->getId());
	}
}

?>
<?php

if(isset($_GET['vid'])) {
	$video = Video::get(htmlentities($_GET['vid']));
	$title = $video->getTitle();
	$id = $video->getId();
	$author = new User($video->getUserId());
	$CurView = '';
	if($title) {
		if(!$video->isSuspended()) {
			if ($video->getVisibility() > 0 || $session->getId() == $video->getUserId() ) {
				if($video->isHalfConverted()) {
					$warn = $lang['video_half_converted'];
				}
				else if(!$video->isFullyConverted()) {
					$warn = $lang['video_not_converted'];
				}

				$desc = $video->getDescription();
				$views = $video->getViews();
				$likes = $video->getLikes();
				$dislikes = $video->getDislikes();
				$path = $video->getPath();
				$tumbnail = $video->getTumbnail();
				$CurView = $video->GetSetView();
				if(isset($GLOBALS['session'])) {
					$isLiked = (Watch::isLiked($_GET['vid']) ) ? 'liked="liked"' : '';
					$isDisliked = (Watch::isDisliked($_GET['vid']) ) ? 'disliked="disliked"' : '';
				}

				if(isset($_POST['submitFlag'])) {
					Watch::flagVideo($video);
				}				
			}
			else {
				$err = $lang['video_private'];
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
		header('Location: /&'.$vid->getId());
	}
}

if(isset($_POST['unflag_vid'])) {
	if(Watch::isModerator($session)) {
		$vid = Video::get(htmlentities($_GET['vid']));
		Watch::unflagVideo($vid);
		header('Location: /&'.$vid->getId());
	}
}

?>
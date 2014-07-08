<?php

if(isset($_GET['vid'])) {
	$video = Video::get(htmlentities($_GET['vid']));
	$title = $video->getTitle();
	$html_title = secure($title);
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
					echo '<script>alert("La vidéo a bien été signalée à notre équipe de modération. Votre requête sera traitée dans les plus bref délais !");</script>';
				}

				$tags = array();
				foreach ($video->getTags() as $tag) {
					$tag = trim($tag);
					$tag = str_replace(',', '', $tag);
					$tag = str_replace(';', '', $tag);
					$tag = str_replace(':', '', $tag);
					$tag = str_replace('.', '', $tag);
					$tag = '<a href="search?q=%23'.$tag.'">#'.$tag.'</a>';
					$tags[] = $tag;
				}
				
				// Recommandations

				$vidslist = new Vidslist();
				$recommandations = $vidslist->getSearchVideos(str_replace(',', '', implode(' ', $video->getTags() ) ), 5);

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
		header('Location: &'.$vid->getId());
		exit();
	}
}

if(isset($_POST['unsuspend_vid'])) {
	if(Watch::isModerator($session)) {
		$vid = Video::get(htmlentities($_GET['vid']));
		Watch::unsuspendVideo($vid->getId());
		header('Location: &'.$vid->getId());
		exit();
	}
}

if(isset($_POST['unflag_vid'])) {
	if(Watch::isModerator($session)) {
		$vid = Video::get(htmlentities($_GET['vid']));
		Watch::unflagVideo($vid);
		header('Location: &'.$vid->getId());
		exit();
	}
}

?>
<?php

if(isset($_GET['vid'])) {
	$video = Video::get(htmlentities($_GET['vid']));
	$title = $video->getTitle();

	if($title) {
		echo '<h2>'.$title.'</h2>';
		echo '<p>There is a video player here. Invisible of course.</p>';

		echo '<br>ID: '.$video->getId();
		echo '<br>Title: '.$title;
		echo '<br>Description: '.$video->getDescription();
		echo '<br>Views: '.$video->getViews();
		echo '<br>Likes: '.$video->getLikes();
		echo '<br>Dislikes: '.$video->getDislikes();
		echo '<br>Author: '.User::getNameById($video->getUserId());
	}
	else
		die('Error occurred while loading the video !');
}

?>
<?php

if(!isset($session) || !isset($_GET['vidId']) ) {
	header('Location: ./');
	exit();
}

$vidId = mysql_real_escape_string($_GET['vidId']);
$video = VideoProperties::getVideoById($vidId);

if($video->getUserId() == $session->getId())
{
	$vidTitle = $video->getTitle();
	$vidDescription = $video->getDescription();
	$vidTags = $video->getTags();
	$vidTagsStr = implode(' ', $vidTags);
	$vidVisibility = $video->getVisibility();
	
	if(isset($_POST['submit'])) {
		echo 'lol: thumb';
		$newVidTitle = mysql_real_escape_string($_POST['vidTitle']);
		$newVidDesc = mysql_real_escape_string($_POST['vidDescription']);
		$newVidTagsStr = mysql_real_escape_string($_POST['vidTags']);
		$newVisibility = mysql_real_escape_string($_POST['vidVisibility']);

		if(isset($_POST['videoTumbnail'])) {
			if($_FILES['videoTumbnail']['name'] != '') {
				if ($_FILES['videoTumbnail']['size'] <= 1000000) {
					$name = $_FILES['videoTumbnail']['name'];
					$explode = explode(".", $name);
					$ext = $explode[count($explode)-1];
					$acceptedExts = array('jpeg', 'jpg', 'png', 'gif', 'tiff', 'svg');

					if (in_array($ext, $acceptedExts)) {
						$tumbnailPath = VideoProperties::uploadTumbnail($session->getName());
						$video->setTumbnail($tumbnailPath);
					}
					else {
						$err = $lang['size_tumbnail'];
						$tumbnailPath = '';
					}
				}
				else {
					$err = $lang['size_tumbnail'];
					return;
				}
			}
		}
		
		$video->setTitle($newVidTitle);
		$video->setDescription($newVidDesc);
		$video->setTags($newVidTagsStr);
		$video->setVisibility($newVisibility);
	
		$video->saveDataToDatabase();
	
		//header('Location: ./?page=manager');
		exit();
	}
}
else
{
	header('Location: ./');
	exit();
}



?>
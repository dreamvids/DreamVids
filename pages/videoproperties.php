<?php

if(!isset($session) | !isset($_GET['vidId'])) {
	header('Location: ./');
	exit();
}

$vidId = mysql_real_escape_string($_GET['vidId']);
$video = VideoProperties::getVideoById($vidId);
$vidTitle = $video->getTitle();
$vidDescription = $video->getDescription();
$vidTags = $video->getTags();
$vidTagsStr = implode(' ', $vidTags);
$vidVisibility = $video->getVisibility();

if(isset($_POST['submit'])) {
	$newVidTitle = mysql_real_escape_string($_POST['vidTitle']);
	$newVidDesc = mysql_real_escape_string($_POST['vidDescription']);
	$newVidTagsStr = mysql_real_escape_string($_POST['vidTags']);
	$newVisibility = mysql_real_escape_string($_POST['vidVisibility']);
	
	$video->setTitle($newVidTitle);
	$video->setDescription($newVidDesc);
	$video->setTags($newVidTagsStr);
	$video->setVisibility($newVisibility);

	$video->saveDataToDatabase();

	header('Location: ./?page=manager');
}



?>
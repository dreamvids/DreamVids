<?php

if(!isset($session) || !isset($_GET['vidId']) ) {
	header('Location: ./');
	exit();
}

$vidId = $_GET['vidId'];
$video = VideoProperties::getVideoById($vidId);

if($video->getUserId() == $session->getId())
{
	$vidTitle = $video->getTitle();
	$vidDescription = $video->getDescription();
	$vidTags = $video->getTags();
	$vidTagsStr = implode(' ', $vidTags);
	$vidVisibility = $video->getVisibility();
	
	if(isset($_POST['submit'])) {
		$newVidTitle = $_POST['vidTitle'];
		$newVidDesc = $_POST['vidDescription'];
		$newVidTagsStr = $_POST['vidTags'];
		$newVisibility = (in_array($vidVisibility, array(0,1,2) ) ) ? $_POST['vidVisibility'] : $vidvisibility;

		if($_FILES['videoTumbnail']['name'] != '') {
			if ($_FILES['videoTumbnail']['size'] <= 1000000) {

				$name = $_FILES['videoTumbnail']['name'];
				$explode = explode(".", $name);
				$ext = $explode[count($explode)-1];
				$acceptedExts = array('jpeg', 'jpg', 'png', 'gif', 'tiff', 'svg');
				$vidId = $_GET['vidId'];
				$video = VideoProperties::getVideoById($vidId);
				if($video->getUserId() == $session->getId()){
					if (in_array(strtolower($ext), $acceptedExts)) {
						$tumbnailPath = VideoProperties::uploadTumbnail($session->getName(),$vidId);
						$video->setTumbnail($tumbnailPath.'?'.time() );
					}
					else {
						$err = $lang['size_tumbnail'];
						$tumbnailPath = '';
					}
				}
				else{
					$err = "Cette vidéo n'existe pas";
				}
			}
			else {
				$err = $lang['size_tumbnail'];
				return;
			}
		}
		
		$video->setTitle($newVidTitle);
		$video->setDescription($newVidDesc);
		$video->setTags($newVidTagsStr);
		$video->setVisibility($newVisibility);
	
		$video->saveDataToDatabase();
	
		header('Location: ./manager');
		exit();
	}
	else {
		$_SESSION['serv'] = getFreestServer();
		if ($_SESSION['serv'] !== false) {
			$hash = hash_hmac('sha256', $_SESSION['serv']['addr'], $_SESSION['serv']['priv_key']);
			file_get_contents($_SESSION['serv']['addr'].'incomings/?fid='.$vidId.'&uid='.$session->getId().'&tid=thumbnail&hash='.$hash);
		}
	}
}
else
{
	header('Location: ./');
	exit();
}



?>

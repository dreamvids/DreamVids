<?php
if (!isset($_POST['submit']) && !isset($_FILES['videoInput']) )
{
	$_SESSION['vid_id'] = Video::generateId(6);
	$_SESSION['serv'] = getFreestServer();
	if (!$_SESSION['serv']) {
		$hash = hash_hmac('sha256', $_SESSION['serv']['addr'], $_SESSION['serv']['priv_key']);
		file_get_contents($_SESSION['serv']['addr'].'incomings/?fid='.$_SESSION['vid_id'].'&uid='.$session->getId().'&tid=video&hash='.$hash);
		file_get_contents($_SESSION['serv']['addr'].'incomings/?fid='.$_SESSION['vid_id'].'&uid='.$session->getId().'&tid=thumbnail&hash='.$hash);
	}
}

$uploadDone = $lang['upload_ok'];

if(!isset($session)) {
	header("Location: /login");
	exit();
}

if(isset($_POST['submit'])) {
	//if($_POST['videoInput'] != '') {
		if($_POST['videoTitle'] != '') {
			if($_POST['videoDescription'] != '') {
				if($_POST['videoTags'] != '') {
					if (Upload::countVideos() == 1) {
						Upload::addDbInfos($session->getId() );
					}
					else {
						$err = $lang['err_no_vid_db'];
					}
				}
				else {
					$err = $lang['error_video_tags_empty'];
					unset($_POST['videoTags']);
				}
			}
			else {
				$err = $lang['error_video_description_empty'];
				unset($_POST['videoDescription']);
			}
		}
		else {
			$err = $lang['error_video_title_empty'];
			unset($_POST['videoTitle']);
		}
	/*}
	else {
		$err = $lang['error_video_file_empty'];
		unset($_POST['videoInput']);
	}*/
}

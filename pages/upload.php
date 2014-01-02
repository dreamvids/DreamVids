<?php

$uploadDone = $lang['upload_ok'];

if(!isset($session)) {
	header("Location: ./");
	exit();
}

if(isset($_POST['submit'])) {
	//if($_POST['videoInput'] != '') {
		if($_POST['videoTitle'] != '') {
			if($_POST['videoDescription'] != '') {
				if($_POST['videoTags'] != '') {
					//Upload::uploadVideo();

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

if(isset($_FILES['videoInput'])) {
	if(isset($session)) {
		echo $session->getSessionId();
		$name = $_FILES['videoInput']['name'];
		$explode = explode(".", $name);
		$ext = $explode[1];
		$acceptedExts = array('webm', 'mp4', 'mov', 'avi', 'wmv');

		if(in_array($ext, $acceptedExts)) {
			Upload::uploadVideo($session);
		}
		else {
			$err = $lang['error_video_type_incorrect'];
			unset($_POST['videoInput']);
		}
	}
	else {
		echo "c le mal";
	}
}

?>
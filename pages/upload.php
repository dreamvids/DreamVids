<?php
if (!isset($_POST['submit']) && !isset($_FILES['videoInput']) )
	$_SESSION['vid_id'] = Video::generateId(6);

$uploadDone = $lang['upload_ok'];

if(!isset($session)) {
	header("Location: ./index.php?page=log");
	exit();
}

if(isset($_POST['submit'])) {
	//if($_POST['videoInput'] != '') {
		if($_POST['videoTitle'] != '') {
			if($_POST['videoDescription'] != '') {
				if($_POST['videoTags'] != '') {
					if (Upload::countVideos() == 1) {
						Upload::addDbInfos();
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

if(isset($_FILES['videoInput'])) {
	if(isset($session)) {
		$name = $_FILES['videoInput']['name'];
		$explode = explode(".", $name);
		$ext = $explode[count($explode)-1];
		$acceptedExts = array('webm', 'mp4', 'mov', 'avi', 'wmv', 'ogg', 'ogv');

		if(in_array($ext, $acceptedExts)) {
			Upload::uploadVideo($session->getId(), $session->getName() );
		}
		else {
			$err = $lang['error_video_type_incorrect'];
			unset($_POST['videoInput']);
		}
	}
}

?>

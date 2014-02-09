<?php
if (!isset($_POST['submit']) && !isset($_FILES['videoInput']) )
	$_SESSION['vid_id'] = Video::generateId(6);

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
						if ($_FILES['videoTumbnail']['name'] != '')
						{	
							if ($_FILES['videoTumbnail']['size'] <= 1000000)
							{
								$name = $_FILES['videoTumbnail']['name'];
								$explode = explode(".", $name);
								$ext = strtolower($explode[count($explode)-1]);
								$acceptedExts = array('jpeg', 'jpg', 'png', 'gif', 'tiff', 'svg');
								if (in_array($ext, $acceptedExts) )
								{
									$tumbnailPath = Upload::uploadTumbnail($session->getName() );
								}
								Upload::addDbInfos($tumbnailPath);
							}
							else
							{
								$err = $lang['size_tumbnail'];
							}
						}
						else
						{
							Upload::addDbInfos('');
						}
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
		$ext = strtolower($explode[count($explode)-1]);
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

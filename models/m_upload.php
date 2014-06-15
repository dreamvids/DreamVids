<?php
class Upload {	
	public static function addDbInfos($userId) {
		if (isset($_POST['submit']) ) {
			$title = $_POST['videoTitle'];
            $description = $_POST['videoDescription'];
            $tags = $_POST['videoTags'];
            $visibility = (in_array($_POST['videoVisibility'], array(0,1,2) ) ) ? $_POST['videoVisibility'] : 2;
            $video = Video::get($_SESSION['vid_id']);
            $video->setTitle($title);
            $video->setDescription($description);
            $video->setTags($tags);
            $video->setVisibility($visibility);
            $video->saveDataToDatabase();
			header('Location: /&'.$video->getId() );
			exit();
		}
	}
	
	public static function countVideos() {
		$db = new BDD();
		$return = $db->select("id", "videos", "WHERE id='".$_SESSION['vid_id']."'");
		$db->close();
		return $db->num_rows($return);
	}
}

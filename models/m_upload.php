<?php

class Upload {
	public static function uploadVideo($userId, $username) {
		if(isset($_FILES['videoInput']) && isset($username)) {
			$name = $_FILES['videoInput']['name'];
			$exp = explode('.', $name);
			$ext = $exp[count($exp)-1];
			$path = 'uploads/'.$username.'/'.$_SESSION['vid_id'].'.'.$ext;

			if(!file_exists('uploads/')){
				mkdir('uploads/');
			}
			if(!file_exists('uploads/'.$username) ) {
				mkdir('uploads/'.$username);
			}

			move_uploaded_file($_FILES['videoInput']['tmp_name'], $path);
			$video = Video::create($_SESSION['vid_id'], $userId, '', '', '', '', $path, 0);
		}
	}
	
	public static function addDbInfos($tumbnailPath) {
		if (isset($_POST['submit']) ) {
			$title = $_POST['videoTitle'];
            $description = $_POST['videoDescription'];
            $tags = $_POST['videoTags'];
            $visibility = $_POST['videoVisibility'];
            $video = Video::get($_SESSION['vid_id']);
            $video->setTitle($title);
            $video->setDescription($description);
            $video->setTags($tags);
            $video->setTumbnail($tumbnailPath);
            $video->setVisibility($visibility);
            $video->saveDataToDatabase();
			convert(getcwd().'/'.$video->getPath());
			header('Location: /watch-'.$video->getId() );
			exit();
		}
	}
	
	public static function countVideos() {
		echo 'COUNT:'.$_SESSION['vid_id'].' <br>';
		$db = new BDD();
		$return = $db->select("id", "videos", "WHERE id='".$_SESSION['vid_id']."'");
		$db->close();
		return $db->num_rows($return);
	}
	
	public static function uploadTumbnail($username) {
		if(isset($_FILES['videoTumbnail']) && isset($username)) {
			$name = $_FILES['videoTumbnail']['name'];
			$exp = explode('.', $name);
			$ext = $exp[count($exp)-1];
			$path = 'uploads/'.$username.'/'.$_SESSION['vid_id'].'.'.$ext;

			if(!file_exists('uploads/')){
				mkdir('uploads/');
			}
			if(!file_exists('uploads/'.$username) ) {
				mkdir('uploads/'.$username);
			}

			move_uploaded_file($_FILES['videoTumbnail']['tmp_name'], $path);
			
			return $path;
		}
	}
}

?>
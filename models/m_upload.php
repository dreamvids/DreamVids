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
			//convert($path);
			$video = Video::create($_SESSION['vid_id'], $userId, '', '', '', '', $path, 0);
		}
	}
	
	public static function addDbInfos() {
		if (isset($_POST['submit']) ) {
			$title = $_POST['videoTitle'];
            $description = $_POST['videoDescription'];
            $tags = $_POST['videoTags'];
            $tumbnail = $_POST['videoTumbnail'];
            $visibility = $_POST['videoVisibility'];
            $video = Video::get($_SESSION['vid_id']);
            $video->setTitle($title);
            $video->setDescription($description);
            $video->setTags($tags);
            $video->setTumbnail($tumbnail);
            $video->setVisibility($visibility);
            $video->saveDataToDatabase();
			convert(getcwd().'/'.$video->getPath());
			header('Location: /watch-'.$video->getId() );
			exit();
		}
	}
}

?>
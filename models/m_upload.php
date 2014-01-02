<?php

class Upload {
	public static function uploadVideo($user) {
		if(isset($_FILES['videoInput']) && isset($user)) {

			$title = $_POST['videoTitle'];
			$description = $_POST['videoDescription'];
			$tags = $_POST['videoTags'];
			$name = $_FILES['videoInput']['name'];

			$path = 'uploads/'.$user->getName().'/'.$name;

			if(!file_exists('uploads/'.$user->getName())) {
				mkdir('uploads/'.$user->getName());
			}

			move_uploaded_file($_FILES['videoInput']['tmp_name'], $path);
			$video = Video::create($user->getId(), $title, $description, $path);

			//header('Location: index.php?page=watch&vid='.$video->getId());
		}
		else echo "lol pas drol";
	}
}

?>
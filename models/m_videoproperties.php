<?php

require_once('./classes/Video.php');

class VideoProperties {

	public static function getVideoById($vidId) {
		return Video::get($vidId);
	}

	public static function uploadTumbnail($username,$vidId) {
		if(isset($_FILES['videoTumbnail']) && isset($username)) {
			$name = $_FILES['videoTumbnail']['name'];
			$exp = explode('.', $name);
			$ext = $exp[count($exp)-1];
			$path = 'uploads/'.$username.'/'.$vidId.'.'.$ext;

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
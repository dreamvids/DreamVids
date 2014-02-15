<?php
require 'm_reg.php';

class Profile  extends Reg 
{
	public static function uploadAvatar($username) {
		if(isset($_FILES['avatar']) && isset($username)) {
			$name = $_FILES['avatar']['name'];
			$exp = explode('.', $name);
			$ext = $exp[count($exp)-1];
			$path = 'uploads/'.$username.'/avatar.'.$ext;

			if(!file_exists('uploads/')){
				mkdir('uploads/');
			}
			if(!file_exists('uploads/'.$username) ) {
				mkdir('uploads/'.$username);
			}

			move_uploaded_file($_FILES['avatar']['tmp_name'], $path);
			
			return $path;
		}
	}
	
	public static function uploadBackground($username) {
		if(isset($_FILES['background']) && isset($username)) {
			$name = $_FILES['background']['name'];
			$exp = explode('.', $name);
			$ext = $exp[count($exp)-1];
			$path = 'uploads/'.$username.'/background.'.$ext;

			if(!file_exists('uploads/')){
				mkdir('uploads/');
			}
			if(!file_exists('uploads/'.$username) ) {
				mkdir('uploads/'.$username);
			}

			move_uploaded_file($_FILES['background']['tmp_name'], $path);
			
			return $path;
		}
	}
}
?>
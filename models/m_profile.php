<?php
require 'm_reg.php';

class Profile  extends Reg {
	
	public static function uploadAvatar($user) {
		$user->setAvatarPath($avatarPath);
		$user->saveDataToDatabase();
	}

}
?>
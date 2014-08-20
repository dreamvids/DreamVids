<?php

require_once MODEL.'user_channel.php';
require_once MODEL.'channel_action.php';
require_once MODEL.'video_vote.php';
require_once MODEL.'video_view.php';
require_once MODEL.'modo_action.php';

class Password extends ActiveRecord\Model {
	
	static $table_name = 'passwords';
	
	public static function generatePass($length) {
		$chars = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		shuffle($chars);
		$pass = substr(implode('', $chars), 0, 9);
		return $pass;
	}
}
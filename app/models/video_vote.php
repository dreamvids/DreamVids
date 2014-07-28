<?php

class VideoVote extends ActiveRecord\Model {

	static $table_name = 'videos_votes';

	public static function generateId($length) {
		$idExists = true;

		while($idExists) {
			$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$id = '';
		
			for ($i = 0; $i < $length - 2; $i++) {
				$id .= $chars[rand(0, strlen($chars) - 1)];
			}

			$id = 'v_'.$id;

			$idExists = VideoVote::exists(array('id' => $id));
		}

		return $id;
	}

}
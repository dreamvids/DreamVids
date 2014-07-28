<?php

class ChannelAction extends ActiveRecord\Model {

	static $table_name = 'channels_actions';

	public static function generateId($length) {
		$idExists = true;

		while($idExists) {
			$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$id = '';
		
			for ($i = 0; $i < $length - 2; $i++) {
				$id .= $chars[rand(0, strlen($chars) - 1)];
			}

			$id = 'a_'.$id;

			$idExists = ChannelAction::exists(array('id' => $id));
		}

		return $id;
	}

}
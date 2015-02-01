<?php

class ChannelAction extends ActiveRecord\Model {

	static $table_name = 'channels_actions';

	public $infos = array();

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

	public static function filterReceiver($admins_ids, $type) {
		
		$admins_ids = trim($admins_ids, ";");
		$admins_ids = explode(';',$admins_ids);
		
		
		foreach ($admins_ids as $k => $v) {
			if(!User::exists($v)) unset($admins_ids[$k]);
		}
		if(!(count($admins_ids) > 0)){
			return ";";
		}
		$users = User::find($admins_ids);
		
		$users = is_array($users) ? $users : array($users);
		$filtered_admins_ids = ";";
		foreach ($users as $k => $user) {
			
			$type_exists = false;
			foreach ($user->getNotificationSettings() as $j => $notification) {
				if($j == $type){
					$type_exists = true;
					if(1==$notification){
						$filtered_admins_ids.="$user->id;";
						break;
					}
				}
			}
			if(!$type_exists){ 
				$filtered_admins_ids.="$user->id;";
			}
		}
		
		return $filtered_admins_ids;
	}

}
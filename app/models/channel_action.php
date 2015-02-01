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

	public static function filterReceiver($receiver_ids, $type) {
		
		$receiver_ids = trim($receiver_ids, ";");
		
		if ($receiver_ids != '') {
			$receiver_ids = explode(';',$receiver_ids);
			
			foreach ($receiver_ids as $k => $v) {
				if(!User::exists($v)) unset($receiver_ids[$k]);
			}
			if(!(count($receiver_ids) > 0)){
				return ";";
			}
			/*$users = User::find($receiver_ids);
			
			$users = is_array($users) ? $users : array($users);*/
			$filtered_receiver_ids = ";";
			foreach ($receiver_ids as $k => $val) {
				if (User::exists($val)) {		
					$user = Usef::find($val);					
					$type_exists = false;
					foreach ($user->getNotificationSettings() as $j => $notification) {
						if($j == $type){
							$type_exists = true;
							if(1==$notification){
								$filtered_receiver_ids.="$user->id;";
								break;
							}
						}
					}
					if(!$type_exists){ 
						$filtered_receiver_ids.="$user->id;";
					}
				}
			}
			
			return $filtered_receiver_ids;
		}
		
		return ';';
	}

}
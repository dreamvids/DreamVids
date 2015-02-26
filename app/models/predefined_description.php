<?php
class PredefinedDescription extends ActiveRecord\Model {
	
	static $table_name = 'predefined_descriptions';
	
	public static function getDescriptionByChannelsids($users_channels_id){
		return PredefinedDescription::find('all', array("users_channels_id" => $users_channels_id));
	}
	
}
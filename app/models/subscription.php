<?php
require_once MODEL . 'user.php';
require_once MODEL . 'user_channel.php';

class Subscription extends ActiveRecord\Model {
	static $belongs_to = [
			['user'],
			['UserChannel']
	];
	
	/**
	 * 
	 * @param $channel Channel ID or channel object
	 */
	public static function getSubscribersFromChannelId($channel){
		if(!($channel instanceof UserChannel)){
			$channel = UserChannel::find($channel);			
		}
		
		return $channel->subscribed_users; 
	}
	
	public static function getSubscribedChannelsFromUserId($user){
		if(!($user instanceof User)){
			$user = UserChannel::find($channel);
		}
		
		return $user->subscribed_channels;
	}
	
	public static function get
	
}
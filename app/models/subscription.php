<?php
require_once MODEL . 'user.php';
require_once MODEL . 'user_channel.php';

class Subscription extends ActiveRecord\Model {
	static $belongs_to = [
			['user'],
			['UserChannel']
	];
	
	static $table_name = 'subscriptions';
	
	/**
	 * 
	 * @param $channel Channel ID or channel object
	 */
	public static function getSubscribersFromChannel($channel){
		if(!($channel instanceof UserChannel)){
			$channel = UserChannel::find($channel);			
		}
		
		return $channel->subscribed_users; 
	}
	
	public static function getSubscribedChannelsFromUser($user){
		if(!($user instanceof User)){
			$user = User::find($channel);
		}
		
		return $user->subscribed_channels;
	}
	
	public static function getSubscribedChannelsFromUserAsList($user){
		if($user instanceof User){
			$id = $user->id;
		}else{
			$id = $user;
		}
		$pdo = Database::getPDOObject();
		$stmt = $pdo->prepare('SELECT DISTINCT user_channel_id FROM ' . self::$table_name . ' WHERE user_id = ?');
		$stmt->execute([$id]);
		
		
		return self::convertOneColumnFetchResultToList($stmt->fetchAll(PDO::FETCH_NUM));
		
	}
	
	public static function getSubscribersFromChannelAsList($channel){
		if($channel instanceof UserChannel){
			$id = $channel->id;
		}else{
			$id = $channel;
		}
		$pdo = Database::getPDOObject();
		$stmt = $pdo->prepare('SELECT DISTINCT user_id FROM ' . self::$table_name . ' WHERE user_channel_id = ?');
		$stmt->execute([$id]);
	
	
		return self::convertOneColumnFetchResultToList($stmt->fetchAll(PDO::FETCH_NUM));
	
	}
	
	/**
	 * Must user PDO::fetchAll(PDO::FETCH_NUM)
	 * @param unknown $array
	 */
	private static function convertOneColumnFetchResultToList($array){
		$result=[];
		foreach ($array as $k => $value) {
			$result[] = $value[0];
		}
		return $result;
	}
	
	public static function get(){
		
	}
	
}
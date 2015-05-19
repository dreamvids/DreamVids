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
	 * @param $channel Channel ID or channel object
	 * @return array of User
	 */
	public static function getSubscribersFromChannel($channel){
		if(!($channel instanceof UserChannel)){
			$channel = UserChannel::find($channel);			
		}
		
		return $channel->subscribed_users; 
	}
	
	/**
	 * 
	 * @param User|int $user
	 * @return array of UserChannel
	 */
	public static function getSubscribedChannelsFromUser($user){
		if(!($user instanceof User)){
			$user = User::find($channel);
		}
		
		return $user->subscribed_channels;
	}
	
	/**
	 * @param User|int $user
	 * @return array of id
	 */
	public static function getSubscribedChannelsFromUserAsList($user){
		if($user instanceof User){
			$id = $user->id;
		}else{
			$id = $user;
		}
		$pdo = Database::getPDOObject();
		$stmt = $pdo->prepare('SELECT DISTINCT user_channel_id FROM ' . self::$table_name . ' WHERE user_id = ? AND user_id IN (SELECT id FROM users WHERE id = user_id) AND user_channel_id IN (SELECT id FROM users_channels WHERE id = user_channel_id) ORDER BY timestamp DESC');
		$stmt->execute([$id]);
		
		
		return self::convertOneColumnFetchResultToList($stmt->fetchAll(PDO::FETCH_NUM));
		
	}
	
	/**
	 * @param UserChannel|string $user
	 * @return array of id
	 */
	public static function getSubscribersFromChannelAsList($channel){
		if($channel instanceof UserChannel){
			$id = $channel->id;
		}else{
			$id = $channel;
		}
		$pdo = Database::getPDOObject();
		$stmt = $pdo->prepare('SELECT DISTINCT user_id FROM ' . self::$table_name . ' WHERE user_channel_id = ? AND user_id IN (SELECT id FROM users WHERE id = user_id) AND user_channel_id IN (SELECT id FROM users_channels WHERE id = user_channel_id) ORDER BY timestamp DESC');
		$stmt->execute([$id]);
	
	
		return self::convertOneColumnFetchResultToList($stmt->fetchAll(PDO::FETCH_NUM));
	
	}
	
	/**
	 * Add an entry if not already exist into `subscriptions` table that associate a `users` and a `users_channel`
	 * @param User|int $user
	 * @param UserChannel|string $channel
	 */
	public static function subscribeUserToChannel($user, $channel){
		$user_id = $user instanceof User ? $user->id : $user;
		$channel_id = $channel instanceof UserChannel ? $channel->id : $channel;
		
		if(!self::exists(['user_id' => $user_id, 'user_channel_id' => $channel_id])){
			self::create([
				'user_id' => $user_id,
				'user_channel_id' => $channel_id,
				'timestamp' => Utils::tps()
			]);
		}
		
	}
	
	/**
	 * Remove all entries from `subscriptions` table that have given `users` `users_channel`
	 * @param User|int $user
	 * @param UserChannel|string $channel
	 */
	public static function unsubscribeUserFromChannel($user, $channel){
		$user_id = $user instanceof User ? $user->id : $user;
		$channel_id = $channel instanceof UserChannel ? $channel->id : $channel;
	
		self::table()->delete(['user_id' => $user_id, 'user_channel_id' => $channel_id]);	
	}
	
	public static function cleanDeleted(){
		Database::getPDOObject()->query("DELETE FROM ".self::table_name()." WHERE user_id NOT IN (SELECT id FROM users) OR user_channel_id NOT IN (SELECT id FROM users_channels)");
		
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
	
}
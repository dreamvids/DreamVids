<?php

require_once MODEL.'video.php';
require_once MODEL.'channel_post.php';
require_once MODEL.'subscription.php';

// Used for multi-user channels
class UserChannel extends ActiveRecord\Model {

	static $table_name = 'users_channels';
	
	static $has_many = [
			['subscriptions'],
			['subscribed_users', 'class_name' => 'user', 'through' => 'subscriptions']
	];
	
	public function getPostedVideos($publicOnly = true) {
		$visibility = ($publicOnly) ? 'AND visibility = '.Config::getValue_('vid_visibility_public') : '';
		return Video::all(array('conditions' => array("poster_id = ? AND visibility != ? ".$visibility, $this->id, Config::getValue_('vid_visibility_suspended')), 'order' => 'timestamp desc'));
	}
	
	public function getAllViews() {
		
		$videos = $this->getPostedVideos();
		$result = 0;
		
		foreach ($videos as $video) {
			
			if(!$video->isSuspended() && !$video->isPrivate()){
			$result += $video->views;				
			}
		}
		return $result;
		
	}
	
	public function getPostedMessages() {
		return ChannelPost::all(array('conditions' => array('channel_id = ?', $this->id), 'order' => 'timestamp desc'));
	}

	public function getSubscribersNumber() {
		return count($this->getSubscribedUsersAsList());
	}

	public function getAdminsNames() {
		$adminsStr = '';
		
		if(strpos($this->admins_ids, ';') !== false) {
			
			$adminsIds = explode(';', $this->admins_ids);
			
			if(empty($adminsIds[count($adminsIds) - 1])) unset($adminsIds[count($adminsIds) - 1]);

				
			foreach ($adminsIds as $id) {
				$adminsStr .= User::exists($id) && $id != "" ? User::find($id)->username.', ' : '';
			}

			$adminsStr = rtrim($adminsStr, ' ,');
		}

		return $adminsStr;
	}
	
	function getArrayAdminsIds($custom_string = null) {
		if($custom_string){
			$trimed = trim($custom_string, ';');
		}else{
			$trimed = trim($this->admins_ids, ';');
		}
		
		$array = explode(";", $trimed);
		return $array;
	}

	public function getAvatar() {
		return (!empty($this->avatar)) ? $this->avatar : Config::getValue_('default-avatar');
	}

	public function getBackground() {
		return (!empty($this->background)) ? $this->background : Config::getValue_('default-background');
	}
	
	public function getSubscribedUsers(){
		return Subscription::getSubscribersFromChannel($this);
	}
	
	public function getSubscribedUsersAsList(){
		return Subscription::getSubscribersFromChannelAsList($this);
	}

	public function belongToUser($userId) {
		if(User::exists($userId)) {
			$ownedChannels = User::find($userId)->getOwnedChannelsAsList();
			if(in_array($this->id, $ownedChannels))
				return true;
			else
				return false;
		}
		else
			return false;
	}

	public function isUsersMainChannel($userId) {
		if(User::exists($userId)) {
			$user = User::find($userId);
			return $user->getMainChannel()->id == $this->id;
		}
		else
			return false;
	}

	public function isVerified() {
		return $this->verified == 1;
	}

	public function hasLiveAccess() {
		return LiveAccess::exists(array('channel_id' => $this->id));
	}

	public function postMessage($messageContent) {

		$post = ChannelPost::create(array(
			'id' => ChannelPost::generateId(6),
			'channel_id' => $this->id,
			'content' => $messageContent,
			'timestamp' => Utils::tps()
		));
		ChannelAction::create(array(
		'id' => ChannelAction::generateId(6),
		'channel_id' => $this->id,
		'recipients_ids' => ';'.implode(';', $this->getSubscribedUsersAsList()).';',
		'type' => 'message',
		'target' => $messageContent,
		'complementary_id' => $post->id,
		'timestamp' => Utils::tps()
		));
		return $post; 
	}

	public function subscribe($subscriber) {
		
		Subscription::subscribeUserToChannel($subscriber, $this);
		
		$subscriberUser = User::find_by_id($subscriber);
		$subscribingChannel = $this;
		$subscribing = $this->id;

		if (!ChannelAction::exists(array('channel_id' => User::find($subscriber)->getMainChannel()->id, 'type' => 'subscription', 'target' => $subscribing))) {		
			ChannelAction::create(array(
				'id' => ChannelAction::generateId(6),
				'channel_id' => User::find($subscriber)->getMainChannel()->id,
				'recipients_ids' => ChannelAction::filterReceiver($subscribingChannel->admins_ids, "subscription"),
				'type' => 'subscription',
				'target' => $subscribing,
				'timestamp' => Utils::tps()
			));
		}
	}

	public function unsubscribe($subscriber) {
		
		Subscription::unsubscribeUserFromChannel($subscriber, $this);
		
		$unsubscriberUser = User::find_by_id($subscriber);
		$unsubscribingChannel = $this;
		$channel_id = $this->id;

		ChannelAction::create(array(
			'id' => ChannelAction::generateId(6),
			'channel_id' => $unsubscriberUser->getMainChannel()->id,
			'recipients_ids' => ChannelAction::filterReceiver($unsubscribingChannel->admins_ids, "unsubscription"),
			'type' => 'unsubscription',
			'target' => $channel_id,
			'timestamp' => Utils::tps()
		));
	}
	
	public static function getBestChannels() {
		return UserChannel::find_by_sql(
			   'SELECT * FROM users_channels
				LEFT OUTER JOIN (SELECT DISTINCT user_id, user_channel_id, COUNT(*) AS total_sub FROM subscriptions GROUP BY user_channel_id) AS total_sub
				ON(total_sub.user_channel_id = users_channels.id)
				ORDER BY total_sub DESC LIMIT 8');
	}

	public static function generateId($length) {
		$idExists = true;

		while($idExists) {
			$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$id = '';
		
			for ($i = 0; $i < $length - 2; $i++) {
				$id .= $chars[rand(0, strlen($chars) - 1)];
			}

			$id = 'c_'.$id;

			$idExists = UserChannel::exists(array('id' => $id));
		}

		return $id;
	}

	public static function getNameById($channelId) {
		return UserChannel::find_by_id($channelId)->name;
	}

	public static function getIdByName($channelName) {
		return @UserChannel::find_by_name($channelName)->id;
	}

	public static function isNameFree($name) {
		return !UserChannel::exists(array('name' => $name));
	}

	public static function addNew($name, $descr, $avatar, $background) {
		$channelId = UserChannel::generateId(6);
		$avatar = Utils::upload($avatar, 'img', 'avatar', $channelId, Config::getValue_('default-avatar'));
		$background = Utils::upload($background, 'img', 'background', $channelId, Config::getValue_('default-background'));

		UserChannel::create(array(
			'id' => $channelId,
			'name' => $name,
			'description' => $descr,
			'owner_id' => Session::get()->id,
			'admins_ids' => ';'.Session::get()->id.';',
			'avatar' => $avatar,
			'background' => $background,
			'subscribers' => 0,
			'subs_list' => '',
			'views' => 0,
			'verified' => 0
		));
	}

	public static function edit($channelId, $name, $descr, $admins_ids, $avatar, $background) {
		$chann = UserChannel::find($channelId);
		$avatar = Utils::upload($avatar, 'img', 'avatar', $channelId, $chann->getAvatar());
		$background = Utils::upload($background, 'img', 'background', $channelId, $chann->getBackground());

		$chann->name = $name;
		$chann->description = $descr;
		$chann->admins_ids = $admins_ids;
		$chann->avatar = $avatar;
		$chann->background = $background;
		$chann->save();
	}
	
	public static function getSearchChannels($query){
		$query = trim(urldecode($query));
		if ($query != '') {
				return UserChannel::find_by_sql(
						'SELECT * FROM users_channels
	LEFT OUTER JOIN 
		(SELECT user_channel_id, COUNT(*) AS total_sub FROM subscriptions GROUP BY user_channel_id) 
			AS total_sub
	ON(total_sub.user_channel_id = users_channels.id) 
	
	WHERE name LIKE ? OR description LIKE ? ORDER BY total_sub DESC LIMIT 6', ["%$query%","%$query%"]);
		}
	}
	

}

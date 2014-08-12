<?php

require_once MODEL.'video.php';
require_once MODEL.'channel_post.php';

// Used for multi-user channels
class UserChannel extends ActiveRecord\Model {

	static $table_name = 'users_channels';

	public function getPostedVideos() {
		return Video::all(array('conditions' => array('poster_id' => $this->id)));
	}

	public function getPostedMessages() {
		return ChannelPost::all(array('conditions' => array('channel_id = ?', $this->id)));
	}

	public function getSubscribersNumber() {
		return $this->subscribers;
	}

	public function getAdminsNames() {
		$adminsStr = '';

		if(strpos($this->admins_ids, ';') !== false) {
			$adminsIds = explode(';', $this->admins_ids);

			if(empty($adminsIds[count($adminsIds) - 1])) unset($adminsIds[count($adminsIds) - 1]);

			foreach ($adminsIds as $id) {
				$adminsStr .= User::exists($id) ? User::find($id)->username.', ' : '';
			}

			$adminsStr = rtrim($adminsStr, ' ,');
		}

		return $adminsStr;
	}

	public function getAvatar() {
		return $this->avatar;
	}

	public function getBackground() {
		return $this->background;
	}

	public function belongToUser($userId) {
		if(User::exists($userId)) {
			$ownedChannels = User::find($userId)->getOwnedChannels();

			if(in_array($this, $ownedChannels))
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

	public function postMessage($messageContent) {
		ChannelAction::create(array(
			'id' => ChannelAction::generateId(6),
			'channel_id' => $this->id,
			'type' => 'message',
			'target' => $messageContent,
			'timestamp' => Utils::tps()
		));

		return ChannelPost::create(array(
			'id' => ChannelPost::generateId(6),
			'channel_id' => $this->id,
			'content' => $messageContent,
			'timestamp' => Utils::tps()
		));
	}

	public function subscribe($subscriber) {
		$subscriberUser = User::find_by_id($subscriber);
		$subscribingChannel = $this;
		$subscribing = $this->id;

		$subscriptionsStr = $subscriberUser->subscriptions;

		if(Utils::stringStartsWith($subscriptionsStr, ';'))
			$subscriptionsStr = substr_replace($subscriptionsStr, '', 0, 1);
		if(Utils::stringEndsWith($subscriptionsStr, ';'))
			$subscriptionsStr = substr_replace($subscriptionsStr, '', -1);

		$subscriptionsArray = explode(';', $subscriptionsStr);

		if(!in_array($subscribing, $subscriptionsArray)) {
			$subscriptionsArray[] = $subscribing;

			$subscriberUser->subscriptions = implode(';', $subscriptionsArray).';';
			$subscriberUser->save();

			$subscribingChannel->subscribers++;
			$subscribingChannel->save();

			UserAction::create(array(
				'id' => UserAction::generateId(6),
				'user_id' => $subscriber,
				'recipients_ids' => $subscribingChannel->admins_ids,
				'type' => 'subscription',
				'target' => $subscribing,
				'timestamp' => Utils::tps()
			));
		}
	}

	public function unsubscribe($subscriber) {
		$subscriberUser = User::find_by_id($subscriber);
		$subscribingChannel = $this;
		$subscribing = $this->id;

		$subscriptionsStr = $subscriberUser->subscriptions;

		if(Utils::stringStartsWith($subscriptionsStr, ';'))
			$subscriptionsStr = substr_replace($subscriptionsStr, '', 0, 1);
		if(Utils::stringEndsWith($subscriptionsStr, ';'))
			$subscriptionsStr = substr_replace($subscriptionsStr, '', -1);

		if(strpos($subscriptionsStr, ';') !== false) {
			$subscriptionsArray = explode(';', $subscriptionsStr);
		}
		else if(strlen($subscriptionsStr) == 6) {
			$subscriptionsArray = array();
			$subscriptionsArray[0] = $subscriptionsStr;
		}

		if(in_array($subscribing, $subscriptionsArray)) {
			$key = array_search($subscribing, $subscriptionsArray);
			unset($subscriptionsArray[$key]);

			$subscriberUser->subscriptions = ';'.implode(';', $subscriptionsArray).';';
			$subscriberUser->save();

			$subscribingChannel->subscribers--;
			$subscribingChannel->save();

			UserAction::create(array(
				'id' => UserAction::generateId(6),
				'user_id' => $subscriber,
				'recipients_ids' => $subscribingChannel->admins_ids,
				'type' => 'unsubscription',
				'target' => $subscribing,
				'timestamp' => Utils::tps()
			));
		}
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

	public static function isNameFree($name) {
		return !UserChannel::exists(array('name' => $name));
	}

	public static function addNew($name, $descr, $avatarURL, $backgroundURL) {
		$channelId = UserChannel::generateId(6);

		UserChannel::create(array(
			'id' => $channelId,
			'name' => $name,
			'description' => $descr,
			'owner_id' => Session::get()->id,
			'admins_ids' => ';'.Session::get()->id.';',
			'avatar' => $avatarURL,
			'background' => $backgroundURL,
			'subscribers' => 0,
			'views' => 0,
			'verified' => 0
		));

		// TODO: decentralized upload
		/*
		 * if(!file_exists('uploads/')) mkdir('uploads/');
		 * mkdir('uploads/'.$channelId.'/');
		 * mkdir('uploads/'.$channelId.'/videos');
		 */
	}

	public static function edit($channelId, $name, $descr, $admins_ids, $avatarURL, $backgroundURL) {
		$chann = UserChannel::find($channelId);

		$chann->name = $name;
		$chann->description = $descr;
		$chann->admins_ids = $admins_ids;
		$chann->avatar = $avatarURL;
		$chann->background = $backgroundURL;
		$chann->save();
	}

}
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
		return ChannelPost::all(array('conditions' => array('channel_id = ?', $this->id), 'order' => 'timestamp desc'));
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
		return (!empty($this->avatar)) ? $this->avatar : Config::getValue_('default-avatar');
	}

	public function getBackground() {
		return (!empty($this->background)) ? $this->background : Config::getValue_('default-background');
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
			'recipients_ids' => ';'.trim($this->subs_list, ';').';',
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

		$subscriptionsStrUser = trim($subscriberUser->subscriptions, ';');
		$subscriptionsStrChannel = trim($subscribingChannel->subs_list, ';');

		$subscriptionsArrayUser = explode(';', $subscriptionsStrUser);
		$subscriptionsArrayChannel = explode(';', $subscriptionsStrChannel);

		if(!in_array($subscribing, $subscriptionsArrayUser)) {
			$subscriptionsArrayUser[] = $subscribing;
			$subscriptionsArrayChannel[] = $subscriberUser->id;

			$subscriberUser->subscriptions = implode(';', $subscriptionsArrayUser).';';
			$subscriberUser->save();

			$subscribingChannel->subscribers++;
			$subscribingChannel->subs_list = implode(';', $subscriptionsArrayChannel).';';
			$subscribingChannel->save();

			if (ChannelAction::exists(array('channel_id' => User::find($subscriber)->getMainChannel()->id, 'type' => 'subscription', 'target' => $subscribing))) {		
				ChannelAction::create(array(
					'id' => ChannelAction::generateId(6),
					'channel_id' => User::find($subscriber)->getMainChannel()->id,
					'recipients_ids' => $subscribingChannel->admins_ids,
					'type' => 'subscription',
					'target' => $subscribing,
					'timestamp' => Utils::tps()
				));
			}
		}
	}

	public function unsubscribe($subscriber) {
		$subscriberUser = User::find_by_id($subscriber);
		$subscribingChannel = $this;
		$subscribing = $this->id;

		$subscriptionsStrUser = trim($subscriberUser->subscriptions, ';');
		$subscriptionsStrChannel = trim($subscribingChannel->subs_list, ';');
		$subscriptionsArrayUser = explode(';', $subscriptionsStrUser);
		$subscriptionsArrayChannel = explode(';', $subscriptionsStrChannel);

		if(in_array($subscribing, $subscriptionsArrayUser)) {
			$key = array_search($subscribing, $subscriptionsArrayUser);
			unset($subscriptionsArrayUser[$key]);
			$key = array_search($subscriber, $subscriptionsArrayChannel);

			unset($subscriptionsArrayChannel[$key]);

			$subscriberUser->subscriptions = implode(';', $subscriptionsArrayUser).';';
			$subscriberUser->save();

			$subscribingChannel->subscribers--;
			$subscribingChannel->subs_list = implode(';', $subscriptionsArrayChannel).';';
			$subscribingChannel->save();

			ChannelAction::create(array(
				'id' => ChannelAction::generateId(6),
				'channel_id' => User::find($subscriber)->getMainChannel()->id,
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
			'subs_list' => 0,
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

}
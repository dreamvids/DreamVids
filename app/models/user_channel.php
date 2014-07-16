<?php

require_once MODEL.'video.php';
require_once MODEL.'user.php';

// Used for multi-user channels
class UserChannel extends ActiveRecord\Model {

	static $table_name = 'users_channels';

	public function getPostedVideos() {
		return Video::all(array('conditions' => array('poster_id' => $this->id)));
	}

	public function getSubscribersNumber() {
		return $this->subscribers;
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

	public static function addNew($name, $descr, $avatarURL, $bannerURL, $backgroundURL) {
		$channelId = UserChannel::generateId(6);

		UserChannel::create(array(
			'id' => $channelId,
			'name' => $name,
			'description' => $descr,
			'owner_id' => Session::get()->id,
			'admins_ids' => Session::get()->id.';',
			'avatar' => $avatarURL,
			'banner' => $bannerURL,
			'background' => $backgroundURL,
			'subscribers' => 0,
			'views' => 0
		));

		if(!file_exists('uploads/')) mkdir('uploads/');
		mkdir('uploads/'.$channelId.'/');
		mkdir('upload/'.$channelId.'/videos');
	}

	public static function edit($channelId, $name, $descr, $avatarURL, $bannerURL, $backgroundURL) {
		$chann = UserChannel::find($channelId);

		$chann->name = $name;
		$chann->description = $descr;
		$chann->avatar = $avatarURL;
		$chann->banner = $bannerURL;
		$chann->background = $backgroundURL;
		$chann->save();
	}

}
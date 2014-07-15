<?php

require_once MODEL.'video.php';
require_once MODEL.'user.php';

// Used for multi-user channels
class UserChannel extends ActiveRecord\Model {

	static $table_name = 'users_channels';

	public function getPostedVideos() {
		return Video::all(array('conditions' => array('poster_id' => $this->id)));
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

	public static function getSubscriptions($userId, $amount='nope') {
		$subscriptions = array();

		if($amount != 'nope') {
			$user = User::find_by_id($userId);
			$subs = $user->subscriptions;

			if(Utils::stringStartsWith($subs, ';'))
				$subs = substr_replace($subs, '', 0, 1);
			if(Utils::stringEndsWith($subs, ';'))
				$subs = substr_replace($subs, '', -1);

			$subscriptionsArray = explode(';', $subs);

			if(count($subscriptionsArray) > $amount) $amount = count($subscriptionsArray);

			for($i = 0; $i < $amount; $i++) {
				$subscriptions[$i] = UserChannel::find_by_id($subscriptionsArray[$i]);
			}
		}
		else {
			$user = User::find_by_id($userId);
			$subs = $user->subscriptions;

			if(Utils::stringStartsWith($subs, ';'))
				$subs = substr_replace($subs, '', 0, 1);
			if(Utils::stringEndsWith($subs, ';'))
				$subs = substr_replace($subs, '', -1);

			if(strpos($subs, ';') !== false) {
				$subscriptionsArray = explode(';', $subs);

				foreach ($subscriptionsArray as $sub) {
					$subscriptions[] = UserChannel::find_by_id($sub);
				}
			}
			else if(strlen($subs) == 6) {
				$subscriptions[0] = UserChannel::find_by_id($subs);
			}
		}

		if(!@$subscriptions[0]) $subscriptions = array();
		return $subscriptions;
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
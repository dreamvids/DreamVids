<?php

require_once SYSTEM.'Model.php';
require_once APP.'classes/User.php';
require_once APP.'classes/UserChannel.php';

class Channels_model extends Model {
	
	public function getChannelsOwnedByUser($userId) {
		$channels = array();

		$channels = UserChannel::all(array('owner_id' => $userId));

		return $channels;
	}
	
	public function addChannel($name, $descr, $avatarURL, $bannerURL, $backgroundURL) {
		UserChannel::create(array(
			'id' => UserChannel::generateId(6),
			'name' => $name,
			'description' => $descr,
			'owner_id' => Session::get()->id,
			'admins_ids' => Session::get()->id,
			'avatar' => $avatarURL,
			'banner' => $bannerURL,
			'background' => $backgroundURL,
			'subscribers' => 0,
			'views' => 0
		));
		if(!file_exists('uploads/')) {
					mkdir('uploads/');
		}
		mkdir('uploads/'.$name.'/');
		mkdir('upload/'.$name.'/videos');
	}

	public function editChannel($channelId, $name, $descr, $avatarURL, $bannerURL, $backgroundURL) {
		$chann = $this->getChannelById($channelId);

		$chann->name = $name;
		$chann->description = $descr;
		$chann->avatar = $avatarURL;
		$chann->banner = $bannerURL;
		$chann->background = $backgroundURL;
		$chann->save();

		if(!file_exists('uploads/')) mkdir('uploads/');
		if(!file_exists('uploads/'.$name.'/')) mkdir('uploads/'.$name.'/');
		if(!file_exists('upload/'.$name.'/videos')) mkdir('upload/'.$name.'/videos');
	}
	
	public function isChannelNameFree($name) {
		return !UserChannel::exists(array('name' => $name));
	}

	public function getChannelById($channelId) {
		return UserChannel::find_by_id($channelId);
	}

	public function isUserMainChannel($username, $channelId) {
		return UserChannel::find_by_id($channelId)->name == $username;
	}

	public function getChannelName($channelId) {
		return UserChannel::find_by_id($channelId)->name;
	}
	
}
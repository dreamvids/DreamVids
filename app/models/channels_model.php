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
	
	public function isChannelNameFree($name) {
		return !UserChannel::exists(array('name' => $name));
	}
	
}
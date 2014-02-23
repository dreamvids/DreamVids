<?php

require_once SYSTEM.'Model.php';
require_once APP.'classes/Video.php';

class Videolist_model extends Model {

	public function getDiscoverVideos() {
		return Video::all(array('limit' => 10, 'order' => 'timestamp desc'));
	}

	public function getSubscriptionsVideos($userId, $amount='nope') {
		$videos = array();
		$user = User::find_by_id($userId);
		$subs = $user->subscriptions;

		if(Utils::stringStartsWith($subs, ';'))
			$subs = substr_replace($subs, '', 0, 1);

		$subs = str_replace(';', ',', $subs);
		$subs = '('.$subs.')';

		if($amount != 'nope')
			$vidsToAdd = Video::find_by_sql("SELECT * FROM videos WHERE user_id IN ".$subs." ORDER BY timestamp DESC LIMIT ".$amount);
		else
			$vidsToAdd = Video::find_by_sql("SELECT * FROM videos WHERE user_id IN ".$subs." ORDER BY timestamp DESC");

		foreach ($vidsToAdd as $vid) {
			array_push($videos, $vid);
		}

		return $videos;
	}

	public function getSubscriptionsVideosFromUser($userId, $fromUser, $amount='nope') {
		$videos = array();
		$user = User::find_by_id($userId);
		$subs = $user->subscriptions;

		if(Utils::stringStartsWith($subs, ';'))
			$subs = substr_replace($subs, '', 0, 1);

		$subs = str_replace(';', ',', $subs);
		$subs = '('.$subs.')';

		if($amount != 'nope')
			$vidsToAdd = Video::find_by_sql("SELECT * FROM videos WHERE user_id=? ORDER BY timestamp DESC LIMIT ".$amount, array($fromUser));
		else
			$vidsToAdd = Video::find_by_sql("SELECT * FROM videos WHERE user_id=? ORDER BY timestamp DESC", array($fromUser));

		foreach ($vidsToAdd as $vid) {
			array_push($videos, $vid);
		}

		return $videos;
	}

	public function userExists($userId) {
		return User::exists(array('id' => $userId));
	}

}
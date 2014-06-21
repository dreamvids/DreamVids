<?php

require_once SYSTEM.'Model.php';
require_once APP.'classes/Video.php';
require_once APP.'classes/UserAction.php';
require_once APP.'classes/ChannelAction.php';

class Feed_model extends Model {

	public function getSubscriptions($userId, $amount='nope') {
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

	public function getSubscriptionsVideos($userId, $amount='nope') {
		$videos = array();
		$user = User::find_by_id($userId);
		$subs = $user->subscriptions;

		if(Utils::stringStartsWith($subs, ';'))
			$subs = substr_replace($subs, '', 0, 1);
		if(Utils::stringEndsWith($subs, ';'))
			$subs = substr_replace($subs, '', -1);

		$subs = str_replace(';', ',', $subs);

		$subArrayTemp = explode(',', $subs);
		$subs = "";
		foreach ($subArrayTemp as $sub) $subs .= "'".$sub."',";

		if(Utils::stringEndsWith($subs, ','))
			$subs = substr_replace($subs, '', -1);

		$subs = "(".$subs.")";
		if($subs == '()') return array();

		if($amount != 'nope')
			$vidsToAdd = Video::find_by_sql("SELECT * FROM videos WHERE poster_id IN ".$subs." ORDER BY timestamp DESC LIMIT ".$amount);
		else
			$vidsToAdd = Video::find_by_sql("SELECT * FROM videos WHERE poster_id IN ".$subs." ORDER BY timestamp DESC");


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
		if(Utils::stringEndsWith($subs, ';'))
			$subs = substr_replace($subs, '', -1);

		$subs = str_replace(';', ',', $subs);
		$subs = '('.$subs.')';

		if($amount != 'nope')
			$vidsToAdd = Video::find_by_sql("SELECT * FROM videos WHERE poster_id=? ORDER BY timestamp DESC LIMIT ".$amount, array($fromUser));
		else
			$vidsToAdd = Video::find_by_sql("SELECT * FROM videos WHERE poster_id=? ORDER BY timestamp DESC", array($fromUser));

		foreach ($vidsToAdd as $vid) {
			array_push($videos, $vid);
		}

		return $videos;
	}

	// Returns the actions that concerns the subsriptions (channels)
	public function getSubscriptionsActions($userId) {
		$actions = array();
		$subscriptions = $this->getSubscriptions($userId);

		foreach($subscriptions as $subscription) {
			$subscriptionsActions = ChannelAction::find('all', array('conditions' => array('channel_id' => $subscription->id)));

			foreach($subscriptionsActions as $action) {
				$actions[] = $action;
			}
		}

		return $actions;
	}

	// Returns actions that concerns the user's videos/channel(s)
	public function getUsersPersonalActions($userId) {
		$actions = array();
		$actionTypes = array('subscription', 'like');
		$user = User::find_by_id($userId);

		foreach($actionTypes as $type) {
			switch ($type) {
				case 'subscription':
					$usersChannels = $user->getOwnedChannels();
					$usersChannelIds = array();
					foreach($usersChannels as $c) $usersChannelIds[] = $c->id;

					$subscriptionsActions = UserAction::find('all', array('conditions' => array(
						'type = ? AND target IN (?)', $type, $usersChannelIds
					)));

					foreach($subscriptionsActions as $sa) $actions[] = $sa;
					break;

				case 'unsubscription':
					$usersChannels = $user->getOwnedChannels();
					$usersChannelIds = array();
					foreach($usersChannels as $c) $usersChannelIds[] = $c->id;

					$subscriptionsActions = UserAction::find('all', array('conditions' => array(
						'type = ? AND target IN (?)', $type, $usersChannelIds
					)));

					foreach($subscriptionsActions as $sa) $actions[] = $sa;
					break;

				case 'like':
					$usersVideos = $user->getPostedVideos();
					$usersVideosIds = array();
					foreach($usersVideos as $vid) $usersVideosIds[] = $vid->id;

					$likeActions = UserAction::find('all', array('conditions' => array(
						'type = ? AND target IN (?)', $type, $usersVideosIds
					)));

					foreach($likeActions as $a) $actions[] = $a;
					break;
				
				default:
					break;
			}
		}

		return $actions;
	}

	public function userExists($userId) {
		return User::exists(array('id' => $userId));
	}

}
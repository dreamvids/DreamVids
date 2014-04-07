<?php

require_once SYSTEM.'Model.php';
require_once APP.'classes/Video.php';
require_once APP.'classes/UserChannel.php';

class Channel_model extends Model {

	public function getVideoesFromChannel($channelId) {
		if(UserChannel::exists(array('id' => $channelId))) {
			return Video::find('all', array('conditions' => array('poster_id = ?', $channelId)));
		}
	}

	public function channelExists($channelId) {
		if(Utils::stringStartsWith($channelId, 'c_'))
			return UserChannel::exists(array('id' => $channelId));

		if(User::exists(array('id' => $channelId))) return true;
		return false;
	}

	public function channelNameExists($channelName) {
		if(UserChannel::exists(array('name' => $channelName)))
			return true;
		else if(User::exists(array('username' => $channelName)))
			return true;
		else
			return false;
	}

	public function createUserChannel($name, $users) {
		if(!$this->channelNameExists($name)) {
			$id = UserChannel::generateId(6);

			UserChannel::create(array('id' => $id, 'name' => $name, 'users' => $users, 'subscribers' => 0, 'views' => 0));
		}
	}

	public function subscribeToChannel($subscriber, $subscribing) {
		$subscriberUser = User::find_by_id($subscriber);
		$subscribingChannel = UserChannel::find_by_id($subscribing);

		$subscriptionsStr = $subscriberUser->subscriptions;

		if(Utils::stringStartsWith($subscriptionsStr, ';'))
			$subscriptionsStr = substr_replace($subscriptionsStr, '', 0, 1);

		$subscriptionsArray = explode(';', $subscriptionsStr);

		if(!in_array($subscribing, $subscriptionsArray)) {
			$subscriptionsArray[] = $subscribing;

			$subscriberUser->subscriptions = implode(';', $subscriptionsArray);
			$subscriberUser->save();

			$subscribingChannel->subscribers++;
			$subscribingChannel->save();
		}
	}

	public function unsubscribeToChannel($subscriber, $subscribing) {
		$subscriberUser = User::find_by_id($subscriber);
		$subscribingChannel = UserChannel::find_by_id($subscribing);

		$subscriptionsStr = $subscriberUser->subscriptions;

		if(Utils::stringStartsWith($subscriptionsStr, ';'))
			$subscriptionsStr = substr_replace($subscriptionsStr, '', 0, 1);

		$subscriptionsArray = explode(';', $subscriptionsStr);

		if(!in_array($subscribing, $subscriptionsArray)) {
			$key = array_search($subscribing, $subscriptionsArray);
			unset($subscriptionsArray[$key]);

			$subscriberUser->subscriptions = implode(';', $subscriptionsArray);
			$subscriberUser->save();

			$subscribingChannel->subscribers--;
			$subscribingChannel->save();
		}
	}

}
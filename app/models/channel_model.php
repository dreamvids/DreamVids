<?php

require_once SYSTEM.'Model.php';
require_once APP.'classes/Video.php';
require_once APP.'classes/MultiUserChannel.php';

class Channel_model extends Model {

	public function getVideoesFromUser($userId) {
		if(User::exists(array('id' => $userId))) {
			return Video::find('all', array('conditions' => array('poster_id = ?', $userId)));
		}
	}

	public function getVideoesFromChannel($channelId) {
		if(MultiUserChannel::exists(array('id' => $channelId))) {
			return Video::find('all', array('conditions' => array('poster_id = ?', $channelId)));
		}
	}

	public function channelExists($channelId) {
		if(Utils::stringStartsWith($channelId, 'c_'))
			return MultiUserChannel::exists(array('id' => $channelId));

		if(User::exists(array('id' => $channelId))) return true;
		return false;
	}

	public function subscribeToUser($subscriber, $subscribing) {
		$subscriberUser = User::find_by_id($subscriber);
		$subscribingUser = User::find_by_id($subscribing);

		$subscriptionsStr = $subscriberUser->subscriptions;

		if(Utils::stringStartsWith($subscriptionsStr, ';'))
			$subscriptionsStr = substr_replace($subscriptionsStr, '', 0, 1);

		$subscriptionsArray = explode(';', $subscriptionsStr);

		if(!in_array($subscribing, $subscriptionsArray)) {
			$subscriptionsArray[] = $subscribing;

			$subscriberUser->subscriptions = implode(';', $subscriptionsArray);
			$subscriberUser->save();

			$subscribingUser->subscribers++;
			$subscribingUser->save();
		}
	}

	public function unsubscribeToUser($subscriber, $subscribing) {
		$subscriberUser = User::find_by_id($subscriber);
		$subscribingUser = User::find_by_id($subscribing);

		$subscriptionsStr = $subscriberUser->subscriptions;

		if(Utils::stringStartsWith($subscriptionsStr, ';'))
			$subscriptionsStr = substr_replace($subscriptionsStr, '', 0, 1);

		$subscriptionsArray = explode(';', $subscriptionsStr);

		if(in_array($subscribing, $subscriptionsArray)) {
			$key = array_search($subscribing, $subscriptionsArray);
			unset($subscriptionsArray[$key]);

			$subscriberUser->subscriptions = implode(';', $subscriptionsArray);
			$subscriberUser->save();

			$subscribingUser->subscribers--;
			$subscribingUser->save();
		}
	}

	public function subscribeToMultiUserChannel($subscriber, $subscribing) {
		$subscriberUser = User::find_by_id($subscriber);
		$subscribingChannel = MultiUserChannel::find_by_id($subscribing);

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

	public function unsubscribeToMultiUserChannel($subscriber, $subscribing) {
		$subscriberUser = User::find_by_id($subscriber);
		$subscribingChannel = MultiUserChannel::find_by_id($subscribing);

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
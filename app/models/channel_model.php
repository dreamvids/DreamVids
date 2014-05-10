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
		return UserChannel::exists(array('id' => $channelId));
	}

	public function channelNameExists($channelName) {
		return UserChannel::exists(array('name' => $channelName));
	}

	public function createUserChannel($name, $users) {
		if(!$this->channelNameExists($name)) {
			$id = UserChannel::generateId(6);

			UserChannel::create(array('id' => $id, 'name' => $name, 'users' => $users, 'subscribers' => 0, 'views' => 0));
		}
	}

	public function userBelongsToChannel($userId, $channelId) {
		if($this->channelExists($channelId)) {
			$channel = UserChannel::find_by_id($channelId);
			$channelAdminsStr = $channel->admins_ids;

			return strpos($channelAdminsStr, $userId.';') !== false;
		}
	}

	public function userSubscribedToChannel($userId, $channelId) {
		if($this->channelExists($channelId)) {
			$user = User::find_by_id($userId);
			$subscriptionsStr = $user->subscriptions;

			return strpos($subscriptionsStr, $channelId) !== false;
		}
	}

	public function subscribeToChannel($subscriber, $subscribing) {
		$subscriberUser = User::find_by_id($subscriber);
		$subscribingChannel = UserChannel::find_by_id($subscribing);

		$subscriptionsStr = $subscriberUser->subscriptions;

		if(Utils::stringStartsWith($subscriptionsStr, ';'))
			$subscriptionsStr = substr_replace($subscriptionsStr, '', 0, 1);
		if(Utils::stringEndsWith($subscriptionsStr, ';'))
			$subscriptionsStr = substr_replace($string, '', -1);

		$subscriptionsArray = explode(';', $subscriptionsStr);

		if(!in_array($subscribing, $subscriptionsArray)) {
			$subscriptionsArray[] = $subscribing;

			$subscriberUser->subscriptions = implode(';', $subscriptionsArray).';';
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
		if(Utils::stringEndsWith($subscriptionsStr, ';'))
			$subscriptionsStr = substr_replace($string, '', -1);

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
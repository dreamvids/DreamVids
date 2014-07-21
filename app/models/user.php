<?php

require_once MODEL.'user_channel.php';
require_once MODEL.'user_session.php';

class User extends ActiveRecord\Model {

	public function getMainChannel() {
		return UserChannel::find_by_name($this->username);
	}

	public function getOwnedChannels() {
		return UserChannel::all(array('conditions' => array('admins_ids LIKE ?', $this->id.';%'), 'order' => 'id desc'));
	}

	public function getPostedVideos() {
		$videos = array();
		$channels = $this->getOwnedChannels();

		foreach($channels as $channel)
			foreach($channel->getPostedVideos() as $vid) $videos[] = $vid;

		return $videos;
	}

	public function getSubscriptions($amount='nope') {
		$subscriptions = array();

		if($amount != 'nope') {
			$subs = $this->subscriptions;

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
			$subs = $this->subscriptions;

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

	public function getSubscriptionsVideos($amount='nope') {
		$videos = array();
		$subs = $this->subscriptions;

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

	public function getSubscriptionsVideosFromChannel($channelId, $amount='nope') {
		$videos = array();
		$subs = $this->subscriptions;

		if(Utils::stringStartsWith($subs, ';'))
			$subs = substr_replace($subs, '', 0, 1);
		if(Utils::stringEndsWith($subs, ';'))
			$subs = substr_replace($subs, '', -1);

		$subs = str_replace(';', ',', $subs);
		$subs = '('.$subs.')';

		if($amount != 'nope')
			$vidsToAdd = Video::find_by_sql("SELECT * FROM videos WHERE poster_id=? ORDER BY timestamp DESC LIMIT ".$amount, array($channelId));
		else
			$vidsToAdd = Video::find_by_sql("SELECT * FROM videos WHERE poster_id=? ORDER BY timestamp DESC", array($channelId));

		foreach ($vidsToAdd as $vid) {
			array_push($videos, $vid);
		}

		return $videos;
	}

	// Returns the actions that concerns the subsriptions (channels)
	public function getSubscriptionsActions() {
		$actions = array();
		$subscriptions = $this->getSubscriptions();

		foreach($subscriptions as $subscription) {
			$subscriptionsActions = ChannelAction::find('all', array('conditions' => array('channel_id' => $subscription->id)));

			foreach($subscriptionsActions as $action) {
				if($action->type == 'comment') {
					if(!Video::exists($action->target))
						continue;

					$targetVideo = Video::find($action->target);

					// If the commented video belongs to any of the user's channels
					if($targetVideo->getAuthor()->belongToUser($this->id)) {
						$actions[] = $action;
					}
				}
				else
					$actions[] = $action;
			}
		}

		return $actions;
	}

	// Returns actions that concerns the user's videos/channel(s)
	public function getUsersPersonalActions() {
		$actions = array();
		$actionTypes = array('subscription', 'like');

		foreach($actionTypes as $type) {
			switch ($type) {
				case 'subscription':
					$usersChannels = $this->getOwnedChannels();
					$usersChannelIds = array();
					foreach($usersChannels as $c) $usersChannelIds[] = $c->id;

					$subscriptionsActions = UserAction::find('all', array('conditions' => array(
						'type = ? AND target IN (?)', $type, $usersChannelIds
					)));

					foreach($subscriptionsActions as $sa) $actions[] = $sa;
					break;

				case 'unsubscription':
					$usersChannels = $this->getOwnedChannels();
					$usersChannelIds = array();
					foreach($usersChannels as $c) $usersChannelIds[] = $c->id;

					$subscriptionsActions = UserAction::find('all', array('conditions' => array(
						'type = ? AND target IN (?)', $type, $usersChannelIds
					)));

					foreach($subscriptionsActions as $sa) $actions[] = $sa;
					break;

				case 'like':
					$usersVideos = $this->getPostedVideos();

					if(!empty($usersVideos)) {
						$usersVideosIds = array();
						foreach($usersVideos as $vid) $usersVideosIds[] = $vid->id;

						$likeActions = UserAction::find('all', array('conditions' => array(
							'type = ? AND target IN (?)', $type, $usersVideosIds
						)));

						foreach($likeActions as $a) $actions[] = $a;
					}
					break;
				
				default:
					break;
			}
		}

		return $actions;
	}

	public function setEmail($newMail) {
		$this->email = $newMail;
		$this->save();
	}

	public function setPassword($newPassword) {
		$this->pass = $newPassword;
		$this->save();
	}

	public function getPassword() {
		return $this->pass;
	}

	public function hasSubscribedToChannel($channelId) {
		if(UserChannel::exists($channelId)) {
			$subscriptionsStr = $this->subscriptions;

			return strpos($subscriptionsStr, $channelId) !== false;
		}
	}

	public function isModerator() {
		$config = new Config(CONFIG.'app.json');
		$config->parseFile();

		return $this->rank == $config->getValue('rankModo');
	}

	public function isAdmin() {
		$config = new Config(CONFIG.'app.json');
		$config->parseFile();

		return $this->rank == $config->getValue('rankAdmin');
	}


	// Static

	public static function getNameById($userId) {
		return User::find_by_id($userId)->username;
	}

	public static function getIdByName($username) {
		return User::find_by_username($username)->id;
	}

	public static function isMailRegistered($mail) {
		return User::exists(array('email' => $mail));
	}

	public static function register($username, $password, $mail) {
		$appConfig = new Config(CONFIG.'app.json');
		$appConfig->parseFile();

		$userRank = $appConfig->getValue('rankUser');

		User::create(array(
			'username' => $username,
			'email' => $mail,
			'pass' => sha1($password),
			'followings' => '',
			'subscriptions' => '',
			'reg_timestamp' => Utils::tps(),
			'reg_ip' => $_SERVER['REMOTE_ADDR'],
			'actual_ip' => $_SERVER['REMOTE_ADDR'],
			'rank' => $userRank
		));

		UserChannel::create(array(
			'id' => UserChannel::generateId(6),
			'name' => $username,
			'description' => '',
			'owner_id' => User::getIdByName($username),
			'admins_ids' => User::getIdByName($username).';',
			'subscribers' => 0,
			'views' => 0
		));
	}

	public static function connect($username, $remember) {
		if(User::find_by_username($username)) {
			$sessid = md5(uniqid());
			$expiration = ($remember) ? Utils::tps() + 365*86400 : Utils::tps() + 24*3600;
			$user = User::find_by_username($username);

			UserSession::create(array('user_id' => $user->id, 'session_id' => $sessid, 'expiration' => $expiration, 'remember' => $remember));
			setcookie('SESSID', $sessid, $expiration);
		}
	}

	public static function logoutCurrent() {
		if(Session::isActive()) {
			UserSession::delete_all(array('conditions' => array('user_id = ?', Session::get()->id)));
			setcookie("SESSID", '', -1);
			Session::set(-1);
		}
	}

}
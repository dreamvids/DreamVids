<?php

require_once MODEL.'user_channel.php';
require_once MODEL.'channel_action.php';
require_once MODEL.'video_vote.php';
require_once MODEL.'video_view.php';
require_once MODEL.'modo_action.php';

class Video extends ActiveRecord\Model {

	public function addView() {
		$duration = $this->duration;
		$hash = sha1($this->id.$_SERVER['REMOTE_ADDR']);
		$view = VideoView::find_by_hash($hash);
		if (!$view || Utils::tps() > $view->date + $duration) {
			$this->views++;
			$this->save();

			if($view)
				$view->delete();

			VideoView::create(array(
				'video_id' => $this->id,
				'hash' => $hash,
				'date' => Utils::tps()
			));

			$chan = $this->getAuthor();
			$chan->views++;
			$chan->save();
		}
	}

	public function getAuthor() {
		return UserChannel::find_by_id($this->poster_id);
	}

	public function getAuthorName() {
		return $this->getAuthor()->name;
	}

	public function getComments() {
		return Comment::all(array('conditions' => array('video_id = ?', $this->id)));
	}

	public function getThumbnail() {
		$thumbnail = Config::getValue_('default-thumbnail');

		if(empty($this->thumbnail)) return $thumbnail;

		if(file_exists($this->thumbnail) || ($isUrl = Utils::isUrlValid($this->thumbnail)))
			$thumbnail = isset($isUrl) ? $this->thumbnail : WEBROOT.$this->thumbnail;
		else if(strpos($this->thumbnail, WEBROOT))
			$thumbnail = $this->thumbnail;

		return $thumbnail;
	}

	public function getAssociatedVideos() {
		$vids = array();
		$maxIndex = Video::count(array('conditions' => array('poster_id' => $this->poster_id)));
		$okay = false;

		while(!$okay) {
			for($i = 0; $i < $maxIndex; $i++) {
				$indexes[$i] = rand(0, $maxIndex - 1);
			}

			$new = array_unique($indexes);
			$okay = count($new) == count($indexes);
			if($okay) $indexes = $new;
		}

		$allVids = Video::find('all');
		foreach ($indexes as $index) $vids[] = $allVids[$index];

		return $vids;
	}

	public function isSuspended() {
		$appConfig = new Config(CONFIG.'app.json');
		$appConfig->parseFile();

		return Video::exists(array('id' => $this->id, 'visibility' => $appConfig->getValue('vid_visibility_suspended')));
	}

	public function isPrivate() {
		$appConfig = new Config(CONFIG.'app.json');
		$appConfig->parseFile();

		return Video::exists(array('id' => $this->id, 'visibility' => $appConfig->getValue('vid_visibility_private')));
	}

	public function isFlagged() {
		return $this->flagged == 1;
	}

	public function isLikedByUser($userId) {
		return VideoVote::exists(array('user_id' => $userId, 'obj_id' => $this->id, 'action' => 'like'));
	}

	public function isDislikedByUser($userId) {
		return VideoVote::exists(array('user_id' => $userId, 'obj_id' => $this->id, 'action' => 'dislike'));
	}

	public function updateInfo($newTitle, $newDescription, $newTags) {
		$this->title = $newTitle;
		$this->description = $newDescription;
		$this->tags = $newTags;

		$this->save();
	}

	public function like($userId) {
		$voteId = VideoVote::generateId(6);
		VideoVote::create(array('id' => $voteId, 'user_id' => $userId, 'type' => 'video', 'obj_id' => $this->id, 'action' => 'like'));

		$this->likes++;
		$this->save();

		ChannelAction::create(array(
			'id' => ChannelAction::generateId(6),
			'channel_id' => User::find($userId)->getMainChannel()->id,
			'recipients_ids' => UserChannel::find($this->poster_id)->admins_ids,
			'type' => 'like',
			'target' => $this->id,
			'timestamp' => Utils::tps()
		));
	}

	public function dislike($userId) {
		$voteId = VideoVote::generateId(6);
		VideoVote::create(array('id' => $voteId, 'user_id' => $userId, 'type' => 'video', 'obj_id' => $this->id, 'action' => 'dislike'));

		$this->dislikes++;
		$this->save();

		ChannelAction::create(array(
			'id' => ChannelAction::generateId(6),
			'channel_id' => User::find($userId)->getMainChannel()->id,
			'recipients_ids' => UserChannel::find($this->poster_id)->admins_ids,
			'type' => 'dislike',
			'target' => $this->id,
			'timestamp' => Utils::tps()
		));
	}

	public function removeLike($userId) {
		if($this->likes >= 1) {
			$this->likes--;
			$this->save();

			VideoVote::delete_all(array('conditions' => array('user_id = ? and obj_id = ?', $userId, $this->id)));
		}
	}

	public function removeDislike($userId) {
		if($this->dislikes >= 1) {
			$this->dislikes--;
			$this->save();

			VideoVote::delete_all(array('conditions' => array('user_id = ? and obj_id = ?', $userId, $this->id)));
		}
	}

	// Admin/modos's actions
	public function flag($userId) {
		if($this->flagged == 0) {
			$this->flagged = 1;
			$this->save();

			/*ChannelAction::create(array(
				'id' => ChannelAction::generateId(6),
				'channel_id' => User::find($userId)->getMainChannel()->id,
				'recepients_ids' => '',
				'type' => 'flag',
				'target' => $this->id,
				'timestamp' => Utils::tps()
			));*/
		}
	}

	public function unFlag($userId) {
		if($this->flagged == 1) {
			$this->flagged = 0;
			$this->save();

			ModoAction::create(array(
				'id' => ModoAction::generateId(6),
				'user_id' => $userId,
				'type' => 'unflag',
				'target' => $this->id,
				'timestamp' => Utils::tps()
			));
		}
	}

	public function suspend($userId) {
		$visibility = Config::getValue_('vid_visibility_suspended');
		$this->visibility = $visibility;
		$this->flagged = 1;
		$this->save();

		ModoAction::create(array(
			'id' => ModoAction::generateId(6),
			'user_id' => $userId,
			'type' => 'suspend',
			'target' => $this->id,
			'timestamp' => Utils::tps()
		));
	}

	public function unSuspend($userId) {
		if($this->isSuspended()) {
			$visibility = Config::getValue_('vid_visibility_public');
			$this->visibility = $visibility;
			$this->flagged = 0;
			$this->save();

			ModoAction::create(array(
				'id' => ModoAction::generateId(6),
				'user_id' => $userId,
				'type' => 'unsuspend',
				'target' => $this->id,
				'timestamp' => Utils::tps()
			));
		}
	}

	public function erase($userId) {
		$this->delete();

		//TODO: Delete file

		if (Session::get()->isModerator() || Session::get()->isAdmin()) {
			ModoAction::create(array(
				'id' => ModoAction::generateId(6),
				'user_id' => $userId,
				'type' => 'delete',
				'target' => $this->id,
				'timestamp' => Utils::tps()
			));
		}
	}

	public static function createTemp($id, $channelId) {
		Video::create(array(
			'id' => $id,
			'poster_id' => $channelId,
			'title' => '[no_info_provided]',
			'description' => '[no_info_provided]',
			'tags' => '[no_info_provided]',
			'tumbnail' => '[no_info_provided]',
			'url' => '[no_info_provided]',
			'views' => 0,
			'likes' => 0,
			'dislikes' => 0,
			'timestamp' => Utils::tps(), // upload start time
			'visibility' => -1,
			'flagged' => 0
		));
	}

	public static function updateURL($vidId, $url) {
		Video::update_all(array(
			'set' => array(
				'url' => $url,
			),
			'conditions' => array(
				'id = ?',
				$vidId
			)
		));
	}

	public static function register($vidId, $channelId, $title, $desc, $tags, $thumb, $timestamp, $visibility) {
		Video::update_all(array(
			'set' => array(
				'poster_id' => $channelId,
				'title' => $title,
				'description' => $desc,
				'tags' => $tags,
				'tumbnail' => $thumb,
				'views' => 0,
				'likes' => 0,
				'dislikes' => 0,
				'timestamp' => $timestamp,
				'visibility' => $visibility,
				'flagged' => 0
			),
			'conditions' => array(
				'id = ?',
				$vidId
			)
		));

		ChannelAction::create(array(
			'id' => ChannelAction::generateId(6),
			'channel_id' => $channelId,
			'recipients_ids' => ';'.trim(Channel::find($channelId)->subs_list, ';').';',
			'type' => 'upload',
			'target' => $vidId,
			'timestamp' => Utils::tps()
		));
	}

	public static function generateId($length) {
		$idExists = true;

		while($idExists) {
			$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$id = '';
		
			for ($i = 0; $i < $length; $i++) {
				$id .= $chars[rand(0, strlen($chars) - 1)];
			}

			$idExists = Video::exists(array('id' => $id));
		}

		return $id;
	}

	public static function getDiscoverVideos($number = 10) {
		$vids = array();
		$indexes = array();
		$okay = false;

		if($number > Video::count()) $number = Video::count('all');

		while(!$okay) {
			for($i = 0; $i < $number; $i++) {
				$indexes[$i] = rand(0, $number - 1);
			}

			$new = array_unique($indexes);
			$okay = count($new) == count($indexes);
			if($okay) $indexes = $new;
		}

		$allVids = Video::find('all');
		foreach ($indexes as $index) $vids[] = $allVids[$index];

		return $vids;
	}

	public static function getSubscriptionsVideos($userId, $amount='nope') {
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
	
	public static function getBestVideos($limit = 'nope') {
		$limit = ($limit == 'nope') ? 30 : $limit;
		return Video::all(array('order' => 'likes/dislikes desc', 'limit' => $limit));
	}

	public static function getReportedVideos($limit = 'nope') {
		if($limit != 'nope') {
			return Video::all(array('conditions' => array('flagged', 1), 'order' => 'timestamp desc', 'limit' => $limit));
		}
		else {
			return Video::all(array('conditions' => array('flagged', 1), 'order' => 'timestamp desc'));
		}
	}

}
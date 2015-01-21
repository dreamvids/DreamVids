<?php

require_once MODEL.'user_channel.php';
require_once MODEL.'channel_action.php';
require_once MODEL.'video_vote.php';
require_once MODEL.'video_view.php';
require_once MODEL.'modo_action.php';
require_once MODEL.'upload.php';

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

	public function getComments($parent) {
		return Comment::all(array('conditions' => array('video_id = ? AND parent = ?', $this->id, $parent), 'order' => 'timestamp desc'));
	}

	public function getThumbnail() {
		return $thumbnail = (!empty($this->tumbnail)) ? $this->tumbnail : Config::getValue_('default-thumbnail');
	}

	public function getAssociatedVideos($nb) {
		$tags = explode(' ', trim($this->tags));
		$tagstr = array();
		foreach ($tags as $tag) {
			$tagstr[] = 'tags LIKE ?';
		}
		$tagstr = implode(' OR ', $tagstr);
		$cond = array_merge(array('id != "'.$this->id.'" AND ('.$tagstr.')'), $tags);
		
		$vids = array();
		$tagsVids = Video::all(array('conditions' => $cond, 'limit' => $nb));

		$vids = (count($tagsVids) < $nb) ? array_merge($tagsVids, Video::getDiscoverVideos($nb - count($tagsVids))) : $tagsVids;
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

	public function updateInfo($newTitle, $newDescription, $newTags, $newThumbnail, $newVisibility) {
		$this->title = $newTitle;
		$this->description = $newDescription;
		$this->tags = $newTags;
		$this->tumbnail = Utils::upload($newThumbnail, 'img', $this->id, $this->poster_id, $this->getThumbnail(), true);
		$this->visibility = (in_array($newVisibility, array(0, 1, 2))) ? $newVisibility : 0;
		$this->save();
		
		if ($newVisibility == 2 && !ChannelAction::exists(array('channel_id' => $this->poster_id, 'type' => 'upload', 'target' => $this->id))) {
			Video::sendUploadNotification($this->id, $this->poster_id);
		}
	}

	public function like($userId) {
		$voteId = VideoVote::generateId(6);
		VideoVote::create(array('id' => $voteId, 'user_id' => $userId, 'type' => 'video', 'obj_id' => $this->id, 'action' => 'like'));

		$this->likes++;
		$this->save();

		if ($userId != Session::get()->id && !ChannelAction::exists(array('channel_id' => User::find($userId)->getMainChannel()->id, 'type' => 'like', 'target' => $this->id))) {
			ChannelAction::create(array(
				'id' => ChannelAction::generateId(6),
				'channel_id' => User::find($userId)->getMainChannel()->id,
				'recipients_ids' => ChannelAction::filterReceiver(UserChannel::find($this->poster_id)->admins_ids, "like"),
				'type' => 'like',
				'target' => $this->id,
				'timestamp' => Utils::tps()
			));
		}
	}

	public function dislike($userId) {
		$voteId = VideoVote::generateId(6);
		VideoVote::create(array('id' => $voteId, 'user_id' => $userId, 'type' => 'video', 'obj_id' => $this->id, 'action' => 'dislike'));

		$this->dislikes++;
		$this->save();

		ChannelAction::create(array(
			'id' => ChannelAction::generateId(6),
			'channel_id' => User::find($userId)->getMainChannel()->id,
			'recipients_ids' => ChannelAction::filterReceiver(UserChannel::find($this->poster_id)->admins_ids, "dislike"),
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
			$this->flagged = 2;
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
		ChannelAction::table()->delete(array("target" => $this->id));
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

	public static function createTemp($id, $channelId, $videoPath, $thumbnailPath, $duration) {
		Video::create(array(
			'id' => $id,
			'poster_id' => $channelId,
			'title' => '[no_info_provided]',
			'description' => '[no_info_provided]',
			'tags' => '[no_info_provided]',
			'tumbnail' => $thumbnailPath,
			'duration' => $duration,
			'url' => $videoPath,
			'views' => 0,
			'likes' => 0,
			'dislikes' => 0,
			'timestamp' => Utils::tps(), // upload start time
			'visibility' => 0,
			'flagged' => 0
		));
	}

	public static function register($vidId, $channelId, $title, $desc, $tags, $thumb, $visibility) {
		$video = Video::find($vidId);
		Upload::find(array('conditions' => array('video_id = ?', $vidId)))->delete();
		$video->title = $title;
		$video->description = $desc;
		$video->tags = $tags;
		$video->visibility = (in_array($visibility, array(0, 1, 2))) ? $visibility : 0;
		$video->tumbnail = Utils::upload($thumb, 'img', $vidId, $channelId, $video->getThumbnail());
		$video->save();
					
		if ($visibility == 2) {
			Video::sendUploadNotification($vidId, $channelId);
		}
	}
	
	public static function sendUploadNotification($videoId, $channelId) {
		ChannelAction::create(array(
			'id' => ChannelAction::generateId(6),
			'channel_id' => $channelId,
			'recipients_ids' => ChannelAction::filterReceiver(';'.trim(UserChannel::find($channelId)->subs_list, ';').';', "upload"),
			'type' => 'upload',
			'target' => $videoId,
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
		return Video::all(array('conditions' => 'discover != 0 AND visibility=2', 'order' => 'discover desc', 'limit' => $number));
	}
	
	public static function getLastVideos($number = 10) {
		return Video::all(array('conditions' => 'visibility=2', 'order' => 'timestamp desc', 'limit' => $number));
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
			$vidsToAdd = Video::find_by_sql("SELECT * FROM videos WHERE poster_id IN ".$subs." AND visibility=2 ORDER BY timestamp DESC LIMIT ".$amount);
		else
			$vidsToAdd = Video::find_by_sql("SELECT * FROM videos WHERE poster_id IN ".$subs." AND visibility=2 ORDER BY timestamp DESC");


		foreach ($vidsToAdd as $vid) {
			array_push($videos, $vid);
		}

		return $videos;
	}
	
	public static function getBestVideos($limit = 'nope') {
		$limit = ($limit == 'nope') ? 30 : $limit;
		return Video::all(array('conditions' => 'visibility=2', 'order' => 'likes/(dislikes+1) desc', 'limit' => $limit));
	}

	public static function getReportedVideos($limit = 'nope') {
		if($limit != 'nope') {
			return Video::all(array('conditions' => array('flagged' => 1), 'order' => 'timestamp desc', 'limit' => $limit));
		}
		else {
			return Video::all(array('conditions' => array('flagged' => 1), 'order' => 'timestamp desc'));
		}
	}
	
	public static function getSearchVideos($query, $order="none") {
		if($order == "none"){
			$order = "timestamp desc"; 
		}
		$query = trim(urldecode($query));
		if ($query != '') {
			if ($query[0] == '#') {
				$query = trim($query, '#');
				return Video::all(array('conditions' => array('tags LIKE ? AND visibility = ?', '%'.$query.'%', Config::getValue_('vid_visibility_public')), 'order' => $order));
			}
			else {
				return Video::all(array('conditions' => array('title LIKE ? OR description LIKE ? OR tags LIKE ? OR poster_id=?', '%'.$query.'%', '%'.$query.'%', '%'.$query.'%', UserChannel::getIdByName($query)), 'order' => $order));
			}
		}
	}
	
	public static function getSearchVideosByTags($tags_array, $order, $contain_all = false) {
		
		if($order == "none"){
			$order = "timestamp desc";
		}
		
		$sql_string = "";
		$args = array();
		$cond = array();
		foreach ($tags_array as $k => $value) {
			$sql_string .= " tags LIKE ? " . ($contain_all ? "AND" : "OR");
			$args[] = "%".$tags_array[$k]."%";
		}
		$sql_string .= $contain_all ? " 1" : " 0";
		
		$cond[] = $sql_string.' AND visibility = ?';
		$cond = array_merge($cond, $args);
		$cond[] = Config::getValue_('vid_visibility_public');

		return Video::all(array('conditions' =>$cond, 'order' => $order));
	}
	
	public static function getDataForGraphByDay() {
		$request = "SELECT DISTINCT day , count(*) AS count FROM (
SELECT *, (ROUND(`timestamp` / (60*60*24))*(60*60*24)) as day FROM `videos`
ORDER BY `videos`.`timestamp`  DESC) AS temp
GROUP BY day";
		$temp = Video::find_by_sql($request);
		$result = [];
		foreach ($temp as $k => $value) {
			$result[] = [date("Y-m-d",$value->day) , $value->count];
		}
		return $result;
	}

}

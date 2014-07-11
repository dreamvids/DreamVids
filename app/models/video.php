<?php

require_once MODEL.'user_channel.php';
require_once MODEL.'channel_action.php';

class Video extends ActiveRecord\Model {

	public function getAuthor() {
		return UserChannel::find_by_id($this->poster_id);
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

}
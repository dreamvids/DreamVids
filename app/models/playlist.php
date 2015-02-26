<?php

require_once MODEL.'video.php';
require_once MODEL.'user_channel.php';

class Playlist extends ActiveRecord\Model {

	static $table_name = 'playlists';

	public function getVideos() {
		$videos = array();
		$videosIds = $this->videos_ids;

		if(strpos($videosIds, ';') !== false) {
			if(strpos($videosIds, ';') === 0) $videosIds = substr($videosIds, 1);
			if(substr($videosIds, -1) === ';') $videosIds = substr($videosIds, 0, -1);

			$videosIdsArray = explode(';', $videosIds);

			foreach($videosIdsArray as $videoId) {
				$video = Video::find($videoId);
				if(is_object($video)) $videos[] = $video;
			}
		}

		return $videos;
	}

	public function getAuthor() {
		return UserChannel::find($this->channel_id);
	}

	public static function generateId($length) {
		$idExists = true;

		while($idExists) {
			$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$id = '';
		
			for ($i = 0; $i < $length; $i++) {
				$id .= $chars[rand(0, strlen($chars) - 1)];
			}

			$idExists = Playlist::exists(array('id' => $id));
		}

		return $id;
	}

}
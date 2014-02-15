<?php

require_once SYSTEM.'Model.php';
require_once APP.'classes/User.php';
require_once APP.'classes/Video.php';
require_once APP.'classes/Comment.php';

class Watch_model extends Model {

	public function getVideoById($videoId) {
		return Video::find_by_id($videoId);
	}

	public function getAuthorsName($videoId) {
		return User::find_by_id(Video::find_by_id($videoId)->user_id)->username;
	}

	public function getAuthorsSubscribers($videoId) {
		return User::find_by_id(Video::find_by_id($videoId)->user_id)->subscribers;
	}

	public function getCommentsOnVideo($videoId) {
		return Comment::all(array('conditions' => array('video_id = ?', $videoId)));
	}

	public function getCommentAuthor($comment) {
		if(is_object($comment)) {
			return User::find_by_id($comment->user_id)->username;
		}
	}

}
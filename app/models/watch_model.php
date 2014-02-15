<?php

require_once SYSTEM.'Model.php';
require_once APP.'classes/User.php';
require_once APP.'classes/Video.php';
require_once APP.'classes/Comment.php';
require_once APP.'classes/VideoVote.php';

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

	public function isVideoLikedByUser($videoId, $userId='nope') {
		if($userId == 'nope' && Session::isActive()) $userId = Session::get()->id;

		return VideoVote::exists(array('user_id' => $userId, 'obj_id' => $videoId, 'action' => 'like'));
	}

	public function isVideoDislikedByUser($videoId, $userId='nope') {
		if($userId == 'nope' && Session::isActive()) $userId = Session::get()->id;

		return VideoVote::exists(array('user_id' => $userId, 'obj_id' => $videoId, 'action' => 'dislike'));
	}

	public function likeVideo($videoId, $userId) {
		VideoVote::create(array('user_id' => $userId, 'type' => 'video', 'obj_id' => $videoId, 'action' => 'like'));

		$likes = Video::find_by_id($videoId)->likes;
		Video::update_all(array('set' => array('likes' => $likes + 1), 'conditions' => array('id' => $videoId)));
	}

	public function dislikeVideo($videoId, $userId) {
		VideoVote::create(array('user_id' => $userId, 'type' => 'video', 'obj_id' => $videoId, 'action' => 'dislike'));

		$dislikes = Video::find_by_id($videoId)->dislikes;
		Video::update_all(array('set' => array('dislikes' => $dislikes + 1), 'conditions' => array('id' => $videoId)));
	}

	public function removeLike($videoId, $userId) {
		$likes = Video::find_by_id($videoId)->likes;

		if($likes >= 1) {
			Video::update_all(array('set' => array('likes' => $likes - 1), 'conditions' => array('id' => $videoId)));
			VideoVote::delete_all(array('conditions' => array('user_id = ? and obj_id = ?', $userId, $videoId)));
		}
	}

	public function removeDislike($videoId, $userId) {
		$dislikes = Video::find_by_id($videoId)->dislikes;

		if($dislikes >= 1) {
			Video::update_all(array('set' => array('dislikes' => $dislikes - 1), 'conditions' => array('id' => $videoId)));
			VideoVote::delete_all(array('conditions' => array('user_id = ? and obj_id = ?', $userId, $videoId)));
		}
	}

}
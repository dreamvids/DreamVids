<?php

require_once MODEL.'channel_action.php';
require_once MODEL.'modo_action.php';

class Comment extends ActiveRecord\Model {

	static $table_name = 'videos_comments';

	public function isLikedByUser($user) {
		if(is_object($user)) {
			return ChannelAction::exists(array('channel_id' => $user->getMainChannel()->id, 'type' => 'like_comment', 'target' => $this->id));
		}

		return false;
	}

	public function isDislikedByUser($user) {
		if(is_object($user)) {
			return ChannelAction::exists(array('channel_id' => $user->getMainChannel()->id, 'type' => 'dislike_comment', 'target' => $this->id));
		}

		return false;
	}

	public function like($user) {
		if(is_object($user) && !$this->isLikedByUser($user)) {
			if($this->isDislikedByUser($user)) {
				$this->undislike($user);
			}

			if (ChannelAction::exists(array('channel_id' => $user->getMainChannel()->id, 'type' => 'like_comment', 'target' => $this->id))) {
				ChannelAction::create(array(
					'id' => ChannelAction::generateId(6),
					'channel_id' => $user->getMainChannel()->id,
					'recipients_ids' => UserChannel::find($this->poster_id)->admins_ids,
					'type' => 'like_comment',
					'target' => $this->id,
					'timestamp' => Utils::tps()
				));
			}

			$this->likes++;
			$this->save();
		}
	}

	public function unlike($user) {
		if(is_object($user) && $this->isLikedByUser($user) && $this->likes > 0) {
			ChannelAction::create(array(
				'id' => ChannelAction::generateId(6),
				'channel_id' => $user->getMainChannel()->id,
				'recipients_ids' => UserChannel::find($this->poster_id)->admins_ids,
				'type' => 'unlike_comment',
				'target' => $this->id,
				'timestamp' => Utils::tps()
			));

			ChannelAction::find(array(
				'channel_id' => $user->getMainChannel()->id,
				'type' => 'like_comment',
				'target' => $this->id
			))->delete();

			$this->likes--;
			$this->save();
		}
	}

	public function dislike($user) {
		if(is_object($user) && !$this->isDislikedByUser($user)) {
			if($this->isLikedByUser($user)) {
				$this->unlike($user);
			}

			ChannelAction::create(array(
				'id' => ChannelAction::generateId(6),
				'channel_id' => $user->getMainChannel()->id,
				'recipients_ids' => UserChannel::find($this->poster_id)->admins_ids,
				'type' => 'dislike_comment',
				'target' => $this->id,
				'timestamp' => Utils::tps()
			));

			$this->dislikes++;
			$this->save();
		}
	}

	public function undislike($user) {
		if(is_object($user) && $this->isDislikedByUser($user) && $this->dislikes > 0) {
			ChannelAction::create(array(
				'id' => ChannelAction::generateId(6),
				'channel_id' => $user->getMainChannel()->id,
				'recipients_ids' => UserChannel::find($this->poster_id)->admins_ids,
				'type' => 'undislike_comment',
				'target' => $this->id,
				'timestamp' => Utils::tps()
			));

			ChannelAction::find(array(
				'channel_id' => $user->getMainChannel()->id,
				'type' => 'dislike_comment',
				'target' => $this->id
			))->delete();

			$this->dislikes--;
			$this->save();
		}
	}

	public function report($reporterUser) {
		if(is_object($reporterUser)) {
			$this->flagged = 1;
			$this->save();
		}
	}

	public function unflag($reporterUser) {
		if(is_object($reporterUser)) {
			ModoAction::create(array(
				'id' => ModoAction::generateId(6),
				'user_id' => $reporterUser->id,
				'type' => 'unflag_comment',
				'target' => $this->id,
				'timestamp' => Utils::tps()
			));

			$this->flagged = 0;
			$this->save();
		}
	}

	public function erase($user) {

		ModoAction::create(array(
			'id' => ModoAction::generateId(6),
			'user_id' => $user->id,
			'type' => 'delete_comment',
			'target' => $this->id,
			'timestamp' => Utils::tps()
		));

		$this->delete();
	}

	public function isReported() {
		return $this->flagged == 1;
	}

	public function getAuthor() {
		return UserChannel::exists($this->poster_id) ? UserChannel::find($this->poster_id) : false;
	}

	public function getVideo() {
		return Video::exists($this->video_id) ? Video::find($this->video_id) : false;
	}

	public static function postNew($authorId, $videoId, $commentContent, $parent) {
		$timestamp = Utils::tps();

		$comment = Comment::create(array(
			'id' => Comment::generateId(6),
			'poster_id' => $authorId,
			'video_id' => $videoId,
			'comment' => $commentContent,
			'likes' => 0,
			'dislikes' => 0,
			'timestamp' => $timestamp,
			'parent' => $parent
		));

		ChannelAction::create(array(
			'id' => ChannelAction::generateId(6),
			'channel_id' => $authorId,
			'recipients_ids' => UserChannel::find(Video::find($videoId)->poster_id)->admins_ids,
			'type' => 'comment',
			'target' => $videoId,
			'timestamp' => $timestamp
		));

		return $comment;
	}

	public static function getReportedComments($limit = 'nope') {
		if($limit != 'nope') {
			return Comment::all(array('conditions' => array('flagged', 1), 'order' => 'timestamp desc', 'limit' => $limit));
		}
		else {
			return Comment::all(array('conditions' => array('flagged', 1), 'order' => 'timestamp desc'));
		}
	}

	public static function generateId($length) {
		$idExists = true;

		while($idExists) {
			$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$id = '';
		
			for ($i = 0; $i < $length; $i++) {
				$id .= $chars[rand(0, strlen($chars) - 1)];
			}

			$idExists = Comment::exists(array('id' => $id));
		}

		return $id;
	}

	// Returns the comment associated with a ChannelAction object
	public static function getByChannelAction($action) {
		if(is_object($action) && isset($action->channel_id)) {
			if($action->type == 'comment') {
				return Comment::find('first', array('conditions' => array(
					'poster_id' => $action->channel_id,
					'timestamp' => $action->timestamp
				)));
			}
		}
	}

}
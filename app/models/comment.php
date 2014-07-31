<?php

require_once MODEL.'user_action.php';

class Comment extends ActiveRecord\Model {

	static $table_name = 'videos_comments';

	public function isLikedByUser($user) {
		if(is_object($user)) {
			return UserAction::exists(array('user_id' => $user->id, 'type' => 'like_comment', 'target' => $this->id));
		}

		return false;
	}

	public function isDislikedByUser($user) {
		if(is_object($user)) {
			return UserAction::exists(array('user_id' => $user->id, 'type' => 'dislike_comment', 'target' => $this->id));
		}

		return false;
	}

	public function like($user) {
		if(is_object($user) && !$this->isLikedByUser($user)) {
			if($this->isDislikedByUser($user)) {
				$dislikeAction = UserAction::find(array('type' => 'dislike_comment', 'user_id' => $user->id, 'target' => $this->id));
				$dislikeAction->delete();

				$this->dislikes--;
				$this->save();
			}

			UserAction::create(array(
				'id' => UserAction::generateId(6),
				'user_id' => $user->id,
				'type' => 'like_comment',
				'target' => $this->id,
				'timestamp' => Utils::tps()
			));

			if($action = UserAction::find(array('user_id' => $user->id, 'type' => 'unlike_comment', 'target' => $this->id)))
				$action->delete();

			$this->likes++;
			$this->save();
		}
	}

	public function unlike($user) {
		if(is_object($user) && $this->isLikedByUser($user) && $this->likes > 0) {
			UserAction::create(array(
				'id' => UserAction::generateId(6),
				'user_id' => $user->id,
				'type' => 'unlike_comment',
				'target' => $this->id,
				'timestamp' => Utils::tps()
			));

			UserAction::find(array(
				'user_id' => $user->id,
				'type' => 'like_comment',
				'target' => $this->id
			))->delete();

			if($action = UserAction::find(array('user_id' => $user->id, 'type' => 'like_comment', 'target' => $this->id)))
				$action->delete();

			$this->likes--;
			$this->save();
		}
	}

	public function dislike($user) {
		if(is_object($user) && !$this->isDislikedByUser($user)) {
			if($this->isLikedByUser($user)) {
				$likeAction = UserAction::find(array('type' => 'like_comment', 'user_id' => $user->id, 'target' => $this->id));
				$likeAction->delete();

				$this->likes--;
				$this->save();
			}

			UserAction::create(array(
				'id' => UserAction::generateId(6),
				'user_id' => $user->id,
				'type' => 'dislike_comment',
				'target' => $this->id,
				'timestamp' => Utils::tps()
			));

			if($action = UserAction::find(array('user_id' => $user->id, 'type' => 'undislike_comment', 'target' => $this->id)))
				$action->delete();

			$this->dislikes++;
			$this->save();
		}
	}

	public function undislike($user) {
		if(is_object($user) && $this->isDislikedByUser($user) && $this->dislikes > 0) {
			UserAction::create(array(
				'id' => UserAction::generateId(6),
				'user_id' => $user->id,
				'type' => 'undislike_comment',
				'target' => $this->id,
				'timestamp' => Utils::tps()
			));

			UserAction::find(array(
				'user_id' => $user->id,
				'type' => 'dislike_comment',
				'target' => $this->id
			))->delete();

			if($action = UserAction::find(array('user_id' => $user->id, 'type' => 'dislike_comment', 'target' => $this->id)))
				$action->delete();

			$this->dislikes--;
			$this->save();
		}
	}

	public static function postNew($authorId, $videoId, $commentContent) {
		$timestamp = Utils::tps();

		$comment = Comment::create(array(
			'id' => Comment::generateId(6),
			'poster_id' => $authorId,
			'video_id' => $videoId,
			'comment' => $commentContent,
			'timestamp' => $timestamp,
			'likes' => 0,
			'dislikes' => 0
		));

		ChannelAction::create(array(
			'id' => ChannelAction::generateId(6),
			'channel_id' => $authorId,
			'type' => 'comment',
			'target' => $videoId,
			'timestamp' => $timestamp
		));

		return $comment;
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
					'timestamp' => $action->timestamp,
					'video_id' => $action->target
				)));
			}
		}
	}

}
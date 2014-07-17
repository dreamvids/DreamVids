<?php

class Comment extends ActiveRecord\Model {

	static $table_name = 'videos_comments';

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
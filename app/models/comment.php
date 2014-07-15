<?php

class Comment extends ActiveRecord\Model {

	static $table_name = 'videos_comments';

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
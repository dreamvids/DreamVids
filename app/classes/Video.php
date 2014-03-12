<?php

class Video extends ActiveRecord\Model {

	public static function createTemp($id, $userId) {
		Video::create(array(
			'id' => $id,
			'user_id' => $userId,
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

	public static function register($vidId, $userId, $title, $desc, $tags, $thumb, $timestamp, $visibility) {
		Video::update_all(array(
			'set' => array(
				'user_id' => $userId,
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

}
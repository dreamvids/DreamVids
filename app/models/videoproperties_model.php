<?php

require_once SYSTEM.'Model.php';
require_once APP.'classes/Video.php';

class Videoproperties_model extends Model {

	public function updateVideoInfo($vidId, $newTitle, $newDescription, $newTags) {
		$video = Video::find_by_id($vidId);

		$video->title = $newTitle;
		$video->description = $newDescription;
		$video->tags = $newTags;

		$video->save();
	}

}
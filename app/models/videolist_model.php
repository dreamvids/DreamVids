<?php

require_once SYSTEM.'Model.php';
require_once APP.'classes/Video.php';

class Videolist_model extends Model {

	public function getDiscoverVideos() {
		$vids = array();
		$maxIndex = 10;
		$okay = false;

		if($maxIndex > Video::count()) $maxIndex = Video::count('all');

		while(!$okay) {
			for($i = 0; $i < $maxIndex; $i++) {
				$indexes[$i] = rand(0, $maxIndex - 1);
			}

			$new = array_unique($indexes);
			$okay = count($new) == count($indexes);
			if($okay) $indexes = $new;
		}

		$allVids = Video::find('all');
		foreach ($indexes as $index) $vids[] = $allVids[$index];

		return $vids;
	}

	public function userExists($userId) {
		return User::exists(array('id' => $userId));
	}

}
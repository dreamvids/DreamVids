<?php

require_once SYSTEM.'Model.php';
require_once APP.'classes/Video.php';

class Videolist_model extends Model {

	public function getDiscoverVideos($number = 10) {
		$vids = array();
		$indexes = array();
		$okay = false;

		if($number > Video::count()) $number = Video::count('all');

		while(!$okay) {
			for($i = 0; $i < $number; $i++) {
				$indexes[$i] = rand(0, $number - 1);
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
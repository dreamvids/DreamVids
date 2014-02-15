<?php

class Annotation {
	private $id = -1;
	private $video_id;
	private $annotations;
	/*
	private $content;
	private $position;
	private $size;
	private $time;
	private $color;*/

	public static function get($video_id) {
		$instance = new self();
		$instance->loadVideo($video_id);

		return $instance;
	}

	private function loadVideo($video_id) {
		$this->video_id = $video_id;
		$db = new BDD();
        $result = $db->select("*", "videos_annot", "WHERE video_id='".$db->real_escape_string($this->video_id)."'") or die(mysql_error());

        $tmp = array();
        $i = 0;
        while($row = $db->fetch_array($result)) {
        	$tmp[$i] = array('id' => $row['id'], 'txt' => $row['content'], 'position' => $row['position'], 'size' => $row['size'], 'time' => $row['time'], 'color' => $row['color'],);
        	$i++;
        }
        $this->annotations = $tmp;
	}

	public function getAnnot() {
		return $this->annotations;
	}
}
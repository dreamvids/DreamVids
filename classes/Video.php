<?php

class Video {

	private $id = -1;
	private $userId;
	private $title;
	private $description;
	private $tags;
	private $tumbnail;
	private $views;
	private $path;
	private $likes;
	private $dislikes;
	private $timestamp;
	private $visibility; // 0: private, 1: not visible, 2: public, 3: suspended by a moderator/admin;
	private $flagged; // the video has been flagged by a user. It will be sent to moderators

	// "constructor" (kind of) for uploading
	public static function create($id, $userId, $title, $description, $tags, $tumbnail, $path, $visibility) {
		$instance = new self();

		$instance->id = $id;
		$instance->userId = $userId;
		$instance->title = $title;
		$instance->description = $description;
		$instance->tags = explode(' ', $tags);
		$instance->tumbnail = $tumbnail;
		$instance->path = $path;
		$instance->views = 0;
		$instance->likes = 0;
		$instance->dislikes = 0;
		$instance->timestamp = tps();
		$instance->visibility = $visibility;
		$instance->flagged = 0;

		$instance->createVideo();
		return $instance;
	}

	// "constructor" (kind of) for viewing
	public static function get($id) {
		$instance = new self();
		$instance->loadVideo($id);

		return $instance;
	}
	

	private function createVideo() {
		$db = new BDD();
		$tagsStr = implode(' ', $this->tags);
		$res1 = $db->insert("videos", "'".$this->id."', '".$this->userId."', '".$db->real_escape_string($this->title)."', '".$db->real_escape_string($this->description)."', '".$db->real_escape_string($tagsStr)."', '".$db->real_escape_string($this->tumbnail)."', '".$db->real_escape_string($this->path)."', '".$this->views."', '".$this->likes."', '".$this->dislikes."', '".$this->timestamp."', '".$this->visibility."', '".$this->flagged."'");
		$db->close();
	}

	private function loadVideo($id) {
		$this->id = $id;
		$db = new BDD();
        $result = $db->select("*", "videos", "WHERE id='".$db->real_escape_string($this->id)."'") or die(mysql_error());

        while($row = $db->fetch_array($result)) {
            $this->id = $row['id'];
            $this->userId = $row['user_id'];
            $this->title = $row['title'];
            $this->description = $row['description'];
            $this->tags = explode(' ', $row['tags']);
            $this->tumbnail = $row['tumbnail'];
            $this->path = $row['url'];
            $this->views = $row['views'];
            $this->likes = $row['likes'];
            $this->dislikes = $row['dislikes'];
            $this->timestamp = $row['timestamp'];
            $this->visibility = $row['visibility'];
            $this->flagged = $row['flagged'];
        }
	}
	
	public function saveDataToDatabase() {
		$db = new BDD();
		$tagsStr = implode(' ', $this->tags);
		$db->update("videos", "title='".$db->real_escape_string($this->title)."', description='".$db->real_escape_string($this->description)."', tags='".$db->real_escape_string($tagsStr)."', tumbnail='".$db->real_escape_string($this->tumbnail)."', visibility=".$this->visibility.", flagged=".$this->flagged, "WHERE id='".$db->real_escape_string($this->id)."'");
	}

	// generates a random string
	public static function generateId($length) {
		$db = new BDD();
		$rows = 1;
		$id = 0;
		while($rows != 0) {
			$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $id = '';
	
		    for ($i = 0; $i < $length; $i++) {
		        $id .= $chars[rand(0, strlen($chars) - 1)];
		    }
			$res0 = $db->select("id", "videos", "WHERE id='".$id."'");
			$rows = $db->num_rows($res0);
		}

	    return $id;
	}

	public function getId() {
		return $this->id;
	}

	public function getUserId() {
		return $this->userId;
	}

	public function getTitle() {
		return $this->title;
	}

	public function getDescription() {
		return $this->description;
	}

	public function getTags() {
		return $this->tags;
	}

	public function getTumbnail() {
		return $this->tumbnail;
	}

	public function getViews() {
		return $this->views;
	}

	public function getPath() {
		return $this->path;
	}

	public function getLikes() {
		return $this->likes;
	}

	public function getDislikes() {
		return $this->dislikes;
	}

	public function getTimestamp() {
		return $this->timestamp;
	}

	public function getVisibility() {
		return $this->visibility;
	}

	public function isFlagged() {
		return $this->flagged;
	}

	public function isSuspended() {
		return $this->visibility == 3;
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function setDescription($desc) {
		$this->description = $desc;
	}
	
	public function setTags($tags) {
		$this->tags = explode(' ', $tags);
	}
	
	public function setTumbnail($tumbnail) {
		$this->tumbnail = $tumbnail;
	}
	
	public function setPath($path) {
		$this->path = $path;
	}
	
	public function setVisibility($visibility) {
		if (in_array($visibility, array(0, 1, 2, 3)))
			$this->visibility = $visibility;
	}
	
	public function setViews() {
		$this->views++;
	}
	
	public function setLikes($bool = true) {
		if ($bool)
			$this->likes++;
		else
			$this->likes--;
	}
	
	public function setDislikes($bool = true) {
		if ($bool)
			$this->dislikes++;
		else
			$this->dislikes--;
	}

	public function setFlagged($flagged) {
		$this->flagged = $flagged;
	}
}

?>
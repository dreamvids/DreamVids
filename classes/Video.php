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
	public static function create($id, $userId, $title='', $description='', $tags='', $tumbnail='', $path='', $visibility=0) {
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

		$db2 = new BDD();
		$res2 = $db2->insert("videos_convert","'', '".$this->id."', '0', '0'");
		$db2->close();		
	}

	private function loadVideo($id) {
		$this->id = $id;
		$db = new BDD();
        
        $result = $db->select("*", "videos", "WHERE id='".mysql_real_escape_string($id)."'") or die(mysql_error());

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
	
	public function GetSetView(){
		$instance = new self();
		$db = new BDD();
		$tmp = time() - (24*60*60);	
		$curhash = $instance->GenHash();
		$result = $db->select("*", "videos_view", "WHERE video_id='".mysql_real_escape_string($this->id)."' and hash='".$curhash."' and date > '".$tmp."'") or die(mysql_error());
		$row = $db->fetch_array($result);
		if (count($row) == 1) {
			$db->update("videos", "views=views+1", "WHERE id='".$db->real_escape_string($this->id)."'");
			$db->insert("videos_view", "'', '".$this->id."', '".$curhash."', '".time()."'");
		}
		return $this->views;
	}
	public function saveDataToDatabase() {
		$db = new BDD();
		$tagsStr = implode(' ', $this->tags);
		$db->update("videos", "title='".$db->real_escape_string($this->title)."', description='".$db->real_escape_string($this->description)."', tags='".$db->real_escape_string($tagsStr)."', tumbnail='".$db->real_escape_string($this->tumbnail)."', visibility=".$this->visibility.", flagged=".$this->flagged, "WHERE id='".$db->real_escape_string($this->id)."'");
	}

	public function delete() {
		if($this->id != -1) {
			$db = new BDD();
			$delReq = $db->delete("videos", "WHERE id='".$this->id."'");
			if(file_exists($this->path."_640x360p.mp4")) unlink($this->path."_640x360p.mp4");
			if(file_exists($this->path."_640x360p.webm")) unlink($this->path."_640x360p.webm");
			if(file_exists($this->path."_1280x720p.mp4")) unlink($this->path."_1280x720p.mp4");
			if(file_exists($this->path."_1280x720p.webm")) unlink($this->path."_1280x720p.webm");
		}
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
		return $this->tumbnail.'?'.time();
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

	public function isFlagged() {
		return $this->flagged == 1;
	}


	public function isFullyConverted() {
		$db = new BDD();
	    $result = $db->select("*", "videos_convert", "WHERE video_id='".$db->real_escape_string($this->id)."' AND sd=2 AND hd=2") or die(mysql_error());
	    return $db->num_rows($result) == 1;
	}

	public function isHalfConverted() {
		$db = new BDD();
	    $result = $db->select("*", "videos_convert", "WHERE video_id='".$db->real_escape_string($this->id)."' AND sd!=0 AND hd=0") or die(mysql_error());
	    return $db->num_rows($result) == 1;
	}
	public static function GenHash()
	{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }
    return md5($ip);
}
}

?>
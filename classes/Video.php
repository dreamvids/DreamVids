<?php

class Video {

	private $id = -1;
	private $userId;
	private $title;
	private $description;
	private $views;
	private $path;
	private $likes;
	private $dislikes;

	// "constructor" (kind of) for uploading
	public static function create($id, $userId, $title, $description, $path) {
		$instance = new self();

		$instance->id = $id;
		$instance->userId = $userId;
		$instance->title = $title;
		$instance->description = $description;
		$instance->path = $path;
		$instance->views = 0;
		$instance->likes = 0;
		$instance->dislikes = 0;

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
		$res1 = $db->insert("videos", "'".$this->id."', '".$this->userId."', '".$db->real_escape_string($this->title)."', '".$db->real_escape_string($this->description)."', '".$db->real_escape_string($this->path)."', '".$this->views."', '".$this->likes."', '".$this->dislikes."'");
		$db->close();
	}

	private function loadVideo($id) {
		$this->id = $id;
		$db = new BDD();
        $result = $db->select("*", "videos", "WHERE id LIKE '%".$this->id."%'") or die(mysql_error());

        while($row = $db->fetch_array($result)) {
            $this->id = $row['id'];
            $this->userId = $row['user_id'];
            $this->title = $row['title'];
            $this->description = $row['description'];
            $this->path = $row['url'];
            $this->views = $row['views'];
            $this->likes = $row['likes'];
            $this->dislikes = $row['dislikes'];
        }
	}
	
	public function saveDataToDatabase() {
		$db = new BDD();
		$db->update("videos", "title='".$db->real_escape_string($this->title)."', description='".$db->real_escape_string($this->description)."'", "WHERE id='".$this->id."'");
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
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function setDescription($desc) {
		$this->description = $desc;
	}
	
	public function setPath($path) {
		$this->path = $path;
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

}

?>
<?php

require_once('User.php');

class Comment {
	private $id;
	private $authorId;
	private $videoId;
	private $content;
	private $timestamp;

	// "constructor" (kind of) for reading purposes
	public static function get($commentId) {
		$instance = new self();
		$instance->loadComment($commentId);

		return $instance;
	}

	// "constructor" (kind of) for posting comment
	public static function create($comment, $authorId, $videoId, $timestamp) {
		$instance = new self();

		$commentId = self::generateId(6);
		while(self::isCommentIdExisting($commentId)) {
			$commentId = self::generateId(6);
		}

		$instance->id = $commentId;
		$instance->authorId = $authorId;
		$instance->videoId = $videoId;
		$instance->content = $comment;
		$instance->timestamp = $timestamp;

		$instance->registerToDB();

		return $instance;
	}

	private function loadComment($id) {
		$this->id = $id;
		$db = new BDD();
        $result = $db->select("*", "videos_comments", "WHERE id LIKE '%".$this->id."%'") or die(mysql_error());

        while($row = $db->fetch_array($result)) {
            $this->id = $row['id'];
            $this->authorId = $row['user_id'];
            $this->videoId = $row['video_id'];
            $this->content = $row['comment'];
            $this->timestamp = $row['timestamp'];
        }
	}

	private function registerToDB() {
		$db = new BDD();
		$res1 = $db->insert("videos_comments", "'".$this->id."', '".$this->authorId."', '".$this->videoId."', '".$db->real_escape_string($this->content)."', '".$db->real_escape_string($this->timestamp)."'");
		$db->close();
	}

	public function updateDB() {
		$db = new BDD();
		$db->update("videos_comments", "user_id='".$this->authorId."', video_id='".$this->videoId."'", "WHERE id='".$this->id."', comment='".$this->content."', timestamp='".$this->timestamp."'");
		$db->close();
	}

	public function setAuthorId($newAuthorId) {
		$this->authorId = $newAuthorId;
	}

	public function setVideoId($newVideoId) {
		$this->videoId = $newVideoId;
	}

	public function setContent($newContent) {
		$this->content = $newContent;
	}

	public function setTimestamp($newTimestamp) {
		$this->timestamp = $newTimestamp;
	}

	public function getAuthorId() {
		return $this->authorId;
	}

	public function getAuthorName() {
		return User::getNameById($this->authorId);
	}

	public function getVideoId() {
		return $this->videoId;
	}

	public function getContent() {
		return $this->content;
	}

	public function getTimestamp() {
		return $this->timestamp;
	}

	// static
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

	public static function isCommentIdExisting($id) {
		$db = new BDD();
		print_r("lol");
        $result = $db->select("*", "videos_comments", "WHERE id LIKE '%".$id."%'") or die(mysql_error());

        return $db->num_rows($result) != 0;
	}

}

?>
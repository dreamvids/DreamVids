<?php

class Video {

	private $id;
	private $user;
	private $title;
	private $description;
	private $views;
	private $path;

	// "constructor" (kind of) for uploading
	public static function create($user, $title, $description, $path) {
		$instance = new self();

		$instance->user = $user;
		$instance->title = $title;
		$instance->description = $description;
		$instance->path = $path;

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
		$id = $this->generateId(6);

		//TODO: Save data to DB
	}

	private function loadVideo($id) {
		//TODO: Load data from DB
	}

	// generates a random string
	private function generateId($length) {
		$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $id = '';

	    for ($i = 0; $i < $length; $i++) {
	        $id .= $chars[rand(0, strlen($chars) - 1)];
	        $i++;
	    }

	    return $id;
	}

	public function getId() {
		return $this->id;
	}

	public function getUser() {
		return $this->user;
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

}

?>
<?php

class RedirectResponse extends Response {

	private $newURL = '';

	public function __construct($newURL) {
		if(filter_var($newURL, FILTER_VALIDATE_URL)) {	
			$this->newURL = $newURL;
		}
		$this->newURL = $newURL;
	}

	public function send() {
		if($this->newURL != '') {
			header('Location: '.$this->newURL);
			exit();
		}
	}

}
<?php

class RedirectResponse extends Response {

	private $newURL = '';

	public function __construct($newURL) {
		//Check if the passed url is a valid url
		if(filter_var($newURL, FILTER_VALIDATE_URL)) {
			//Prevent phising attack or malredirect link
			$newURL_host = parse_url($newURL)["host"];
			if ($_SERVER['HTTP_HOST'] == $newURL_host) {
				$this->newURL = $newURL;
			}else{
				$this->newURL = WEBROOT;
			}	
		}else{
			if (preg_match("#^".WEBROOT."#", $newURL) && !strstr($newURL, PHP_EOL)) {
				$this->newURL = $newURL;
			}
			else {
				$this->newURL = WEBROOT;
			}
		}
	}

	public function send() {
		if($this->newURL != '') {
			header('Location: '.$this->newURL);
			exit();
		}
	}

}
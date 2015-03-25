<?php

require_once SYSTEM.'response.php';

class JavaScriptResponse extends Response {

	private $data = array();

	public function __construct($viewFile, $data = []) {
		
		
		if(is_array($data)) {
			$this->protocol = 'HTTP/1.1';
			$this->statusCode = '200';
			$this->statusString = 'OK';
			$this->contentType = 'application/javascript';
			
			$file = VIEW.$viewFile.'.php';

			if(file_exists($file)) {
				$this->body = $file;
			}
			
			$this->data = $data;
		}
	}
	
	public function send() {
		header($this->protocol.' '.$this->statusCode.' '.$this->statusString);
		header('Content-Type: '.$this->contentType);
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		extract($this->data);
		include $this->body;
		
	}

}

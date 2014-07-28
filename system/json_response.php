<?php

require_once SYSTEM.'response.php';

class JsonResponse extends Response {

	private $data = array();

	public function __construct($data) {
		$this->body = '{}';
		
		if(is_array($data)) {
			$this->protocol = 'HTTP/1.1';
			$this->statusCode = '200';
			$this->statusString = 'OK';
			$this->contentType = 'application/json';

			$this->data = $data;
			$this->jsonify();
		}
	}

	private function jsonify() {
		if(is_array($this->data)) {
			$this->body = json_encode($this->data);
		}
	}

	public function send() {
		header($this->protocol.' '.$this->statusCode.' '.$this->statusString);
		header('Content-Type: '.$this->contentType);

		echo $this->body;
	}

}
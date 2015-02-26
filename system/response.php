<?php

class Response {

	public static $status = array(
		'200' => 'OK',
		'201' => 'Created',
		'301' => 'Moved Permanently',
		'400' => 'Bad Request',
		'401' => 'Unauthorized',
		'403' => 'Forbidden',
		'404' => 'Not found',
		'500' => 'Internal Server Error',
		'503' => 'Service Unavailable'
	);

	protected $protocol = 'HTTP/1.1';
	protected $statusCode = '200';
	protected $statusString = 'OK';
	protected $contentType = 'text/html';
	protected $body;

	public function __construct($statusCode) {
		$this->setStatusCode($statusCode);
	}

	public function setStatusCode($statusCode) {
		if(isset(Response::$status[$statusCode])) {
			$this->statusCode = $statusCode;
			$this->statusString = Response::$status[$statusCode];
		}
		else {
			$this->statusCode = '404';
			$this->statusString = Response::$status[$this->statusCode];	
		}
	}

	public function setBody($body) {
		$this->body = $body;
	}

	public function send() {
		header($this->protocol.' '.$this->statusCode.' '.$this->statusString);
		header('Content-Type: '.$this->contentType);

		echo $this->body;
	}

}
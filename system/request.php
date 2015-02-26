<?php

require_once SYSTEM.'methods.php';
require_once SYSTEM.'utils.php';

class Request {

	private $protocol = "HTTP/1.1";
	private $method = Method::INVALID;
	private $uri = '';
	private $fullURI = '';
	private $acceptedData = 'text/html';
	private $parameters = array();

	public function __construct($protocol, $method, $uri, $acceptedData) {
		$this->protocol = $protocol;
		$this->method = $method;
		$this->acceptedData = $acceptedData;
		$this->fullURI = "http://".@$_SERVER[HTTP_HOST].@$_SERVER[REQUEST_URI];
		$uri = trim($uri, '?');
		if(Utils::stringEndsWith($uri, '.json')) {
			$this->acceptedData .= ',application/json';
			$uri = str_replace('.json', '', $uri);
		}
		
		$this->uri = $uri;
	}

	public function setParameters($parameters) {
		$this->parameters = $parameters;
	}

	public function addParameter($key, $value) {
		$this->parameters[$key] = $value;
	}

	public function getProtocol() {
		return $this->protocol;
	}

	public function getMethod() {
		return $this->method;
	}

	public function getURI() {
		return $this->uri;
	}
	
	public function getFullURI() {
		return $this->fullURI;
	}

	public function getAcceptedData() {
		return $this->acceptedData;
	}
	
	public function getAcceptedLanguages() {
		return isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : null;
	}

	public function acceptsHtml() {
		return strpos($this->acceptedData, 'text/html') !== false;
	}

	public function acceptsJson() {
		return strpos($this->acceptedData, 'application/json') !== false;
	}

	public function getParameter($key) {
		return isset($this->parameters[$key]) ? $this->parameters[$key] : false;
	}

	public function getParameters() {
		return $this->parameters;
	}

}
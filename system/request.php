<?php

require_once SYSTEM.'methods.php';
require_once SYSTEM.'utils.php';

class Request {

	private $protocol = "HTTP/1.1";
	private $method = Method::INVALID;
	private $uri = '';
	private $acceptedData = 'text/html';
	private $parameters = array();

	public function __construct($protocol, $method, $uri, $acceptedData) {
		$this->protocol = $protocol;
		$this->method = $method;
		$this->acceptedData = $acceptedData;

		if(Utils::stringStartsWith($uri, '/')) $uri = substr_replace($uri, '', 0, 1);
		if(Utils::stringEndsWith($uri, '/')) $uri = substr_replace($uri, '', strlen($uri) - 1, 1);

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

	public function getAcceptedData() {
		return $this->acceptedData;
	}

	public function acceptsHtml() {
		return strpos($this->acceptedData, 'text/html') !== false;
	}

	public function acceptsJson() {
		return strpos($this->acceptedData, 'application/json') !== false;
	}

	public function getParameters() {
		return $this->parameters;
	}

}
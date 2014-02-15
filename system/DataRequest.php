<?php

class DataRequest {

	private $type = '';
	private $data = array();

	public function __construct($type, $data) {
		$this->type = $type;
		$this->data = $data;
	}

	public function getType() {
		return $this->type;
	}

	public function getValue($key) {
		return $this->data[$key];
	}

	public function getValues() {
		return $this->data;
	}

}
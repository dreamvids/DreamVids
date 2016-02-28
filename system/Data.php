<?php
class Data {
	private static $instance = null;
	private $data;
	
	private function __construct(){
		$this->data = [];
	}
	
	public static function get(): Data {
		if (self::$instance == null) {
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
	public function add(string $name, $value) {
		$this->data[$name] = $value;
	}
	
	public function getData(): array {
		return $this->data;
	}
	
	public function setData(array $data) {
		if (is_array($data)) {
			$this->data = $data;
		}
	}
}
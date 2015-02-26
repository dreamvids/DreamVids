<?php

class ViewMessage {

	private $type = 0; // 0: Error 1: Success
	private $text = '';

	private function __construct($type, $text) {
		$this->type = $type;
		$this->text = $text;
	}

	public function isError() {
		return $this->type == 0;
	}

	public function isSuccess() {
		return $this->type == 1;
	}

	public function getText() {
		return $this->text;
	}


	// Static ""constructors""
	public static function error($text) {
		$message = new ViewMessage(0, $text);
		return $message;
	}

	public static function success($text) {
		$message = new ViewMessage(1, $text);
		return $message;
	}

}
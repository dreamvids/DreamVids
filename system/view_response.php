<?php

require_once SYSTEM.'config.php';
require_once SYSTEM.'response.php';

class ViewResponse extends Response {

	private $data = array();
	private $messages = array();
	private $renderLayout = true;

	public function __construct($viewFile, $data = array(), $renderLayout = true) {
		$file = VIEW.$viewFile.'.php';

		if(file_exists($file)) {
			$this->protocol = 'HTTP/1.1';
			$this->statusCode = '200';
			$this->statusString = 'OK';
			$this->contentType = 'text/html';

			if(is_array($data)) $this->data = $data;
			$this->body = $file;
			$this->renderLayout = $renderLayout;
		}
	}

	public function addMessage($message) {
		if(is_object($message) && get_class($message) == 'ViewMessage') {
			$this->messages[] = $message;
		}
	}

	public function send() {
		$appConfig = new Config(CONFIG.'app.json');
		$appConfig->parseFile();

		header($this->protocol.' '.$this->statusCode.' '.$this->statusString);
		header('Content-Type: '.$this->contentType);

		if($this->renderLayout && file_exists(VIEW.$appConfig->getValue('layout').'.php')) {
			$layoutFile = VIEW.$appConfig->getValue('layout').'.php';
			
			extract($this->data);
			$content = $this->body;

			if(file_exists(VIEW.'layouts/messages.php')) {
				$messagesArray = $this->messages;
				$messages = VIEW.'layouts/messages.php';
			}

			include $layoutFile;
		}
		else {
			extract($this->data);
			include $this->body;
		}
	}

}
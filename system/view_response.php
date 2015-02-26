<?php

require_once SYSTEM.'config.php';
require_once SYSTEM.'response.php';

class ViewResponse extends Response {

	private $data = array();
	private $messages = array();
	private $renderLayout = true;
	private $layoutFile = 'layouts/main.php';

	public function __construct($viewFile, $data = array(), $renderLayout = true, $layoutFile = '', $statusCode = 200) {
		$uri = explode('/', Utils::getCurrentURI());
		$admin = (strtolower($uri[0]) == 'admin');
		
		if ($layoutFile == '') {
			$layoutFile = ($admin) ? 'layouts/admin.php' : 'layouts/main.php';
		}
		
		$file = VIEW.$viewFile.'.php';

		if(file_exists($file)) {
			$this->protocol = 'HTTP/1.1';
			$this->setStatusCode($statusCode);
			$this->contentType = 'text/html';

			if(is_array($data)) $this->data = $data;
			$this->body = $file;

			$this->renderLayout = $renderLayout;
			if(file_exists(VIEW.$layoutFile)) $this->layoutFile = $layoutFile;
		}
	}

	public function addMessage($message) {
		if(is_object($message) && get_class($message) == 'ViewMessage') {
			$this->messages[] = $message;
		}
	}

	public function send() {
		header($this->protocol.' '.$this->statusCode.' '.$this->statusString);
		header('Content-Type: '.$this->contentType);

		if($this->renderLayout && file_exists(VIEW.$this->layoutFile)) {
			$this->data = Utils::securingData($this->data);
			extract($this->data);
			$content = $this->body;

			if(file_exists(VIEW.'layouts/messages.php')) {
				$messagesArray = $this->messages;
				$messages = VIEW.'layouts/messages.php';
			}

			include VIEW.$this->layoutFile;
		}
		else {
			extract($this->data);
			include $this->body;
		}
	}

}
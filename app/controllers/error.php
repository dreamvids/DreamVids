<?php

class Error extends Controller {

	public function index() {

	}

	public function notFound() {
		header('HTTP/1.0 404 Not Found');
		$this->renderView('errors/404', null, false);
		exit();
	}

}
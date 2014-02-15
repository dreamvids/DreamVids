<?php

class Error extends Controller {

	public function index() {

	}

	public function notFound() {
		$this->renderView('errors/404', null, false);
		exit();
	}

}
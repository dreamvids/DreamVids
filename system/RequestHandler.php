<?php

class RequestHandler {

	public static function process() {
		if(isset($_POST) && $_POST != array()) {
			self::postRequest();
		}
		if(isset($_GET) && $_GET != array())
			self::getRequest();
	}

	private static function postRequest() {
		$request = new DataRequest('post', $_POST);
		Application::instance()->callMethodFromController('postRequest', $request);
	}

	private static function getRequest() {
		$request = new DataRequest('get', $_GET);
		Application::instance()->callMethodFromController('getRequest', $request);
	}

}
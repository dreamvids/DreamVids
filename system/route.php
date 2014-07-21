<?php

class Route {

	private static $routes = array();

	private $url = '';
	private $controller = '';

	private function __construct($url, $controller) {
		$this->url = $url;
		$this->controller = $controller;
	}

	public function getURL() {
		return $this->url;
	}

	public function getController() {
		return strtolower($this->controller);
	}


	// Static
	public static function register($uri, $controllerName) {
		array_push(self::$routes, new Route($uri, $controllerName));
	}

	public static function getByURL($url) {
		foreach (self::$routes as $route) {
			if($route->getURL() == $url) {
				return $route;
			}
		}

		return false;
	}

}
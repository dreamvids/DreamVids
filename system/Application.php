<?php

class Application {

	private static $instance;
	private $request = array(); // array: URL request
	private $controller;

	public static function create($request) {
		$instance = new self;
		$instance->request = $request;

		self::$instance = $instance;
		return self::$instance;
	}

	public function init() {
		ActiveRecord\Config::initialize(function($cfg) {
			$dbHost = $GLOBALS['config']['db_host'];
			$dbUser = $GLOBALS['config']['db_user'];
			$dbPass = $GLOBALS['config']['db_password'];
			$dbDatabase = $GLOBALS['config']['db_database'];

			$cfg->set_model_directory(APP.'classes');
			$cfg->set_connections(array(
				'development' => 'mysql://'.$dbUser.':'.$dbPass.'@'.$dbHost.'/'.$dbDatabase));
		});
	}

	public function start() {
		$request = $this->request;

		if($request[0] == '') $request = array();

		switch (count($request)) {
			case 0:
				$this->loadController($GLOBALS['config']['defaultController']);
				break;

			case 1:
				$this->loadController($request[0]);
				break;

			case 2:
				$this->loadController($request[0], $request[1]);
				break;
			
			default:
				$params = $request;
				unset($params[0]);
				unset($params[1]);
				$this->loadController($request[0], $request[1], $params);
				break;
		}
	}

	public function loadController($controller, $action='nope', $params='nope') {
		$controllerPath = CONTROLLER.$controller.'.php';
		$controller = ucfirst($controller);

		if(file_exists($controllerPath)) {
			require $controllerPath;
		}

		if(!class_exists($controller)) {
			$this->throwNotFoundError();
			return;
		}

		if($action == 'nope') {
			if(method_exists($controller, 'index')) {
				$ctrler = new $controller();
				$ctrler->index();
				$this->controller = $ctrler;
				return;
			}
			else {
				$this->throwNotFoundError();
				return;
			}
		}
		else {
			if(method_exists($controller, $action)) {
				if($params == 'nope') {
					$ctrler = new $controller();
					call_user_func(array($ctrler, $action));
					$this->controller = $ctrler;
					return;
				}
				else {
					$ctrler = new $controller();
					call_user_func_array(array($ctrler, $action), $params);
					$this->controller = $ctrler;
					return;
				}
			}
			else {
				$request = $this->request;
				unset($request[0]);
				
				if($request) {
					if(method_exists($controller, 'index')) {
						$ctrler = new $controller();
						call_user_func_array(array($ctrler, 'index'), $request);
						$this->controller = $ctrler;
					}
					else {
						$this->throwNotFoundError();
						return;
					}
				}
				else {
					$this->throwNotFoundError();
					return;
				}
			}
		}
	}

	public function callMethodFromController($action, $args='nope') {
		if($args == 'nope') {
			if(is_object($this->controller)) {
				if(method_exists($this->controller, $action)) {
					call_user_func(array($this->controller, $action));
				}
			}
		}
		else {
			if(is_object($this->controller)) {
				if(method_exists($this->controller, $action)) {
					$func_to_call_args = array();

					for ($i=0; $i < func_num_args(); $i++) { 
						if($i != 0) {
							$func_to_call_args[$i-1] = func_get_arg($i);
						}
					}
					
					call_user_func_array(array($this->controller, $action), $func_to_call_args);
				}
			}
		}
	}

	public function throwNotFoundError() {
		ob_end_clean();
		$this->loadController('error', 'notFound');
		exit();
	}


	// static
	public static function instance() {
		return self::$instance;
	}
}
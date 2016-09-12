<?php

class Router {
    private static $instance = null;
    public static $controllers = [
        'home' => 'home',
        'auth' => 'auth',
        'register' => 'register'
    ];

    private $controller = null;

    private function __construct() {
        if (self::controllerExists()) {
            $this->controller = self::$controllers[Request::get()->getArg(0)];
        }
        else {
            Controller::error404();
            exit();
        }
    }

    public static function get() {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function controllerExists() {
        return array_key_exists(Request::get()->getArg(0), self::$controllers);
    }

    public function getPathToRequire() {
        return CONTROLLERS.$this->controller.'.php';
    }
}
<?php
define('NAME', 'MVC');
define('POST', $_SERVER['REQUEST_METHOD'] == 'POST');
define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']), true);
define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']), true);
define('SYSTEM', ROOT.'system/');
define('APP', ROOT.'app/');
define('MODELS', APP.'models/');
define('VIEWS', APP.'views/');
define('CONTROLLERS', APP.'controllers/');
define('ASSETS', WEBROOT.'assets/');
define('CSS', ASSETS.'css/');
define('JS', ASSETS.'js/');
define('FONTS', ASSETS.'fonts/');
define('IMG', ASSETS.'img/');


// System requires
require_once SYSTEM.'Database.php';
require_once SYSTEM.'Controller.php';
require_once SYSTEM.'ModelInterface.php';
require_once SYSTEM.'Model.php';
require_once SYSTEM.'Entry.php';
require_once SYSTEM.'Utils.php';
require_once SYSTEM.'Request.php';
require_once SYSTEM.'Data.php';


// Models
require_once MODELS.'Example.php';


if (!file_exists(CONTROLLERS.Request::get()->getArg(0).'.php') ) {
	Controller::error404();
	exit();
}

require_once CONTROLLERS.Request::get()->getArg(0).'.php';
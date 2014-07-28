<?php
<<<<<<< HEAD

define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']), true);
define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']), true);
define('SYSTEM', ROOT.'system/');

define('LIB', ROOT.'lib/');
define('APP', ROOT.'app/');
define('CONFIG', APP.'config/');
define('CONTROLLER', APP.'controllers/');
define('MODEL', APP.'models/');
define('VIEW', APP.'views/');

define('ASSETS', WEBROOT.'assets/');
define('IMG', WEBROOT.'assets/img/');
define('CSS', WEBROOT.'assets/css/');
define('JS', WEBROOT.'assets/js/');
define('PANEL', WEBROOT.'assets/panel/');

require 'vendor/autoload.php';

include SYSTEM.'Application.php';
include SYSTEM.'Utils.php';
include SYSTEM.'Controller.php';
include SYSTEM.'DataRequest.php';
include SYSTEM.'RequestHandler.php';

include CONFIG.'config.php';
include APP.'classes/Session.php';

session_start();
ob_start();

$req = Utils::parseURL(key($_GET));
$app = Application::create($req);
$app->init();

Session::init();

$app->start();

RequestHandler::process();

ob_end_flush();
=======

define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']), true);
define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']), true);
define('SYSTEM', ROOT.'system/');

define('APP', ROOT.'app/');
define('CONFIG', APP.'config/');
define('CONTROLLER', APP.'controllers/');
define('VIEW', APP.'views/');
define('MODEL', APP.'models/');

define('ASSETS', WEBROOT.'assets/');
define('IMG', WEBROOT.'assets/img/');
define('CSS', WEBROOT.'assets/css/');
define('JS', WEBROOT.'assets/js/');

require 'vendor/autoload.php';

require_once SYSTEM.'config.php';
require_once SYSTEM.'utils.php';
require_once SYSTEM.'route.php';
require_once SYSTEM.'router.php';
require_once SYSTEM.'database.php';

require_once MODEL.'session.php';

require_once CONFIG.'app.php';

Database::connect();
Session::init();
$router = new Router();

$request = Utils::getPerformedRequest();
$router->executeRequest($request);
>>>>>>> dreamvids-2.0-dev

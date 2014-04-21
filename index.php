<?php

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
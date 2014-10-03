<?php

define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']), true);
define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']), true);
define('SYSTEM', ROOT.'system/');
define('SCRIPT', ROOT.'scripts/');
define('CACHE', ROOT.'cache/');

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
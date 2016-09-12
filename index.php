<?php
date_default_timezone_set('Europe/Paris');

define('NAME', 'DreamVids');
define('POST', $_SERVER['REQUEST_METHOD'] == 'POST');
define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']), true);
define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']), true);
define('BEANS', ROOT.'beans/');
define('SYSTEM', ROOT.'system/');
define('APP', ROOT.'app/');
define('LANGDIR', ROOT.'lang/');
define('MODELS', APP.'models/');
define('VIEWS', APP.'views/');
define('CONTROLLERS', APP.'controllers/');
define('ASSETS', WEBROOT.'assets/');
define('CSS', ASSETS.'css/');
define('JS', ASSETS.'js/');
define('FONTS', ASSETS.'fonts/');
define('IMG', ASSETS.'img/');

if (isset($_COOKIE['lang']) && file_exists(LANGDIR.$_COOKIE['lang'].'.json')) {
	$lang = $_COOKIE['lang'];
}
elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && file_exists(LANGDIR.$_SERVER['HTTP_ACCEPT_LANGUAGE'].'.json')) {
	$lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
}
else {
	$lang = 'fr'; // TODO: change default language if needed
}

define('LANG', $lang);

// Vendor
require_once 'vendor/autoload.php';

// System requires
require_once SYSTEM.'ModelInterface.php';
require_once SYSTEM.'Utils.php';
require_once SYSTEM.'Controller.php';
require_once SYSTEM.'Request.php';
require_once SYSTEM.'Data.php';
require_once SYSTEM.'Client.php';
require_once SYSTEM.'Lang.php';
require_once SYSTEM.'Router.php';

// Models
require_once MODELS.'Session.php';
require_once MODELS.'Token.php';
require_once MODELS.'User.php';

if (isset($_COOKIE['SESSID'])) {
	Client::get()->setSessid($_COOKIE['SESSID']);
}

require_once Router::get()->getPathToRequire();
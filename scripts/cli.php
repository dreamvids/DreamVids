<?php
if ($argc < 2) {
	echo 'Usage: php cli.php <module> [options]'.PHP_EOL;
	exit();
}

$root = (substr($argv[0], 0, 1) == '/') ? $argv[0] : getcwd().'/'.trim(preg_replace("#^\.+#isU", "", $argv[0]), '/');
$root = str_replace('scripts/cli.php', '', $root);
$root = str_replace('\\', '/', $root);

define('ROOT', $root);
define('SYSTEM', ROOT.'system/');
define('SCRIPT', ROOT.'scripts/');
define('APP', ROOT.'app/');
define('VENDOR', ROOT.'vendor/');
define('CACHE', ROOT.'cache/');

define('CONFIG', APP.'config/');
define('MODEL', APP.'models/');

require VENDOR.'autoload.php';

require_once SYSTEM.'config.php';
require_once SYSTEM.'utils.php';
require_once SYSTEM.'database.php';

require_once CONFIG.'app.php';

require_once MODEL.'backup.php';
require_once MODEL.'storage_server.php';

Database::connect();

require_once $argv[1].'.php';
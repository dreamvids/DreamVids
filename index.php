<?php

include('includes/functions.php');
require_once('classes/Config.php');
require_once('classes/LoggedUser.php');

session_start();
//TODO: Update mysql connection settings
initDataBaseConfig('127.0.0.1', 'root', '', 'dreamvids');

echo '<h1 style="text-align:center">Welcome to DreamVids.Fr !</h1>';

// This is how to get the mysql host from config
echo 'Mysql host: '.Config::get('mysql/host');

?>
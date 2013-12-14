<?php
require_once('classes/User.php');

session_start();

echo '<h1 style="text-align:center">Welcome to DreamVids.Fr !</h1>';

$user = new User('testname');
?>
<?php

if(!isset($session) | !isset($_GET['uid'])) {
	header('Location: ./?page=log');
	exit();
}

$user = new User(htmlentities(mysql_real_escape_string($_GET['uid'])));

if($user->getId() <= 0) {
	header('Location: ./');
	exit();
}

?>
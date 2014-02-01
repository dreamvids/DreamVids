<?php

if(!isset($session) || !isset($_GET['uid']) ) {
	header('Location: ./?page=log');
	exit();
}

$user = new User($_GET['uid']);

if($user->getId() <= 0) {
	header('Location: ./');
	exit();
}

?>
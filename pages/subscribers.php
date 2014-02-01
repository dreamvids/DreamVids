<?php

if(!isset($session) || !isset($_GET['uid']) ) {
	//header('Location: ./?page=log');
	echo 'C\'est celle de la session qui merde !';
	exit();
}

$user = new User($_GET['uid']);

if($user->getId() <= 0) {
	//header('Location: ./');
	echo 'C\'est celle du paramètre d\'URL qui merde !';
	var_dump($user);
	exit();
}

?>
<?php

if(!isset($session)) {
	header('Location: /login');
	exit();
}

if($session->getRank() <= 0) {
	header('Location: ./');
	exit();
}



?>
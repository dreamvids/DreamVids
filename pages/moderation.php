<?php

if(!isset($session)) {
	header('Location: ./page=log');
	exit();
}

if($session->getRank() <= 0) {
	header('Location: ./');
	exit();
}



?>
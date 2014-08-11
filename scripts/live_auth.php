<?php

file_put_contents('log.txt', 'Coucou', FILE_APPEND);

try {
	$pdo = new PDO('mysql:host=127.0.0.1;dbname=dreamvids_v2', 'root', 'root');

	if(isset($_GET['name'], $_GET['type']) && $_GET['type'] == 'live') {
		$key = $_GET['name'];

		$query = $pdo->prepare('SELECT * FROM `live_accesses` WHERE `key`=:access');
		$query->execute(array(':access' => $key));

		if($query->rowCount() == 1) {
			header('HTTP/1.1 200 OK');
			exit();
		}
	}
}
catch(Exception $e) {
	header('HTTP/1.1 401 Unauthorized');
	exit();
}

header('HTTP/1.1 401 Unauthorized');
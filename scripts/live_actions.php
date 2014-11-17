<?php

// This script is called by the RTMP server

function secure($input) {
	return htmlentities(strip_tags(stripslashes($input)), ENT_QUOTES, 'UTF-8');
}

$application = isset($_POST['app']) ? secure($_POST['app']) : null;
$clientId = isset($_POST['clientid']) ? secure($_POST['clientid']) : null;
$clientIp = isset($_POST['addr']) ? secure($_POST['addr']) : null;
$action = isset($_POST['call']) ? secure($_POST['call']) : null;
$name = isset($_POST['name']) ? secure($_POST['name']) : null;
$key = isset($_POST['key']) ? secure($_POST['key']) : null;

//file_put_contents('lol.txt', print_r($_POST, true).PHP_EOL, FILE_APPEND);

try {
	$pdo = new PDO('mysql:host=127.0.0.1;dbname=dreamvids_v2', 'root', '');

	switch ($action) {
		case 'publish':
			if(is_null($key) | is_null($name)) break;

			$query = $pdo->prepare('SELECT * FROM `live_accesses` WHERE `key`=:access');
			$query->execute(array(':access' => $key));

			if($query->rowCount() == 1) {
				$onlineQuery = $pdo->prepare("UPDATE `live_accesses` SET `online`=1, `stream_name`=?, `viewers`=0 WHERE `key`=?");
				$onlineQuery->execute(array($name, $key));

				header('HTTP/1.1 200 OK');
				exit();
			}
			break;
		case 'publish_done':
			if(is_null($key)) break;

			$onlineQuery = $pdo->prepare("UPDATE `live_accesses` SET `online`=0, `viewers`=0 WHERE `key`=?");
			$onlineQuery->execute(array($key));

			header('HTTP/1.1 200 OK');
			exit();
			break;

		case 'play':
			if(is_null($name)) break;

			$onlineQuery = $pdo->prepare("UPDATE `live_accesses` SET `viewers`=`viewers`+1 WHERE `stream_name`=?");
			$onlineQuery->execute(array($name));

			header('HTTP/1.1 200 OK');
			exit();
			break;

		case 'play_done':
			if(is_null($name)) break;

			$onlineQuery = $pdo->prepare("UPDATE `live_accesses` SET `viewers`=`viewers`-1 WHERE `stream_name`=?");
			$onlineQuery->execute(array($name));

			header('HTTP/1.1 200 OK');
			exit();
			break;
		case 'record_done':
			if(isset($_POST['path'])) {
				$recordedFilePath = secure($_POST['path']);

				if(file_exists($recordedFilePath)) {
					shell_exec('php /usr/local/nginx/html/DreamVids/scripts/converter.php live-record '.$name);
				}
			}

			header('HTTP/1.1 200 OK');
			exit();
			break;
		
		default:
			break;
	}
}
catch(Exception $e) {
	header('HTTP/1.1 401 Unauthorized');
	exit();
}

header('HTTP/1.1 500 Internal Server Error');

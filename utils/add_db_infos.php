<?php
include '../includes/functions.php';
include '../includes/bdd.class.php';
include '../classes/Video.php';
include '../classes/User.php';
$bdd = new BDD();
$data = $bdd->fetch_array($bdd->select("address, private_key", "storage_servers", "WHERE id='".$bdd->real_escape_string(@$_GET['sid'])."'") );

if (hash_hmac("sha256", $data['address'], $data['private_key']) == @$_GET['hash']) {
	switch (@$_GET['tid']) {
		case 'video':
			if (Video::exist($_GET['fid']) )
				$video = Video::get($_GET['fid']);
			else
				$video = Video::create($_GET['fid'], $_GET['uid']);
			$video->setPath(urldecode($_GET['url']) );
			$video->saveDataToDatabase();
			break;
		
		case 'thumbnail':
			if (Video::exist($_GET['fid']) )
				$video = Video::get($_GET['fid']);
			else
				$video = Video::create($_GET['fid'], $_GET['uid']);
			$video->setTumbnail(urldecode($_GET['url']).'?'.time() );
			$video->saveDataToDatabase();
			break;
		
		case 'avatar':
			$user = new User($_GET['uid']);
			$user->setAvatarPath(urldecode($_GET['url']).'?'.time() );
			$user->saveDataToDatabase();
			break;
		
		case 'background':
			$user = new User($_GET['uid']);
			$user->setBackgroundPath(urldecode($_GET['url']).'?'.time() );
			$user->saveDataToDatabase();
			break;
		
		default:
			header('HTTP/1.1 403 Forbidden');
			echo '<h1>403 Forbidden</h1>';
			break;
	}
}
else {
	header('HTTP/1.1 403 Forbidden');
	echo '<h1>403 Forbidden</h1>';
}

$bdd->close();
?>
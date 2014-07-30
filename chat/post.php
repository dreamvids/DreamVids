<?php
session_start();
$lang_path = '../';
include '../includes/bdd.class.php';
include '../includes/functions.php';
include '../classes/LoggedUser.php';
include '../includes/tasks.php';
if(isset($session)){
	$user_id = $session->getId();
	$pseudo = $session->getName();
} else {
	if(isset($_SESSION['user_id'])) $user_id = $_SESSION['user_id'];
	else $user_id = $_SESSION['user_id'] = '-'.uniqid();

}
require_once('db.php');

$last = time() - 10;
if(isset($_POST['getMsg'])){
	$messages = $db->query("SELECT * FROM chat WHERE time > $last AND user_id!='$user_id' ORDER BY id");
	foreach ($messages as $message) {
		if(strstr($message['user_id'], '-')){
			$pseudo = "Anonyme-".substr($message['user_id'], -5);
			echo "
				<div class=\"message\">
					<img src=\"http://lorempixel.com/20/20/cats/?". $message['user_id'] ."\" class=\"avatar\" /><div class=\"pseudo\">" . $pseudo . "</div>
					<div class=\"text\">" . $message['message'] . "</div>
				</div>
			";
		}
		else{
			$user = new User($message['user_id']);
			echo "
				<div class=\"message\">
					<a href=\"http://dreamvids.fr/@" . $user->getUsername() . "\" target=\"_blank\"><img src=\"" . $user->getAvatarPath() . "\" class=\"avatar\" /><div class=\"pseudo\">" . $user->getUsername() . "</div></a>
					<div class=\"text\">" . $message['message'] . "</div>
				</div>
			";
		}
	}
}
if(isset($_POST['message'])){
	$message = $_POST['message'];
	$req = $db->prepare("INSERT INTO chat(user_id,message,time) VALUES(:user_id, :message, :time)");
	$req->bindParam(':user_id', $user_id);
	$req->bindParam(':message', $message);
	$time = time();
	$req->bindParam(':time', $time);
	$req->execute();
	if(!isset($session)){
		$pseudo = 'Moi';
		echo "
			<div class=\"message me\">
				<img src=\"http://lorempixel.com/20/20/cats/?". $_SESSION['user_id'] ."\" class=\"avatar\" /><div class=\"pseudo\">" . $pseudo . "</div>
				<div class=\"text\">" . $message . "</div>
			</div>
		";
	} else {
		echo "
			<div class=\"message me\">
				<a href=\"http://dreamvids.fr/@" . $pseudo . "\" target=\"_blank\"><img src=\"" . $session->getAvatarPath() . "\" class=\"avatar\" /><div class=\"pseudo\">" . $pseudo . "</div></a>
				<div class=\"text\">" . $message . "</div>
			</div>
		";
	}
}
?>
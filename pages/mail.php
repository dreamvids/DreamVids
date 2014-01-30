<?php

if(!isset($session)) {
	header('Location: ./');
	exit();
}

if(isset($_GET['recipient'])) {
	$recipientId = htmlentities(mysql_real_escape_string($_GET['recipient']));
	if($recipientId != '') $recipient = new User($recipientId);
}

if(isset($_POST['sendSubmit'])) {
	if(isset($recipientId) && $recipientId != '') {
		$message = htmlentities(mysql_real_escape_string($_POST['sendMessage']));
		$sender = $session->getId();

		Mail::sendMessageTo($sender, $recipientId, $message);
	}
}

?>
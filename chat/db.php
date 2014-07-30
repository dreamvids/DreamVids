<?php
$user = "root";
$pass = "";
try {
	$db = new PDO('mysql:host=localhost;dbname=dreamvids', $user, $pass);
} catch (PDOException $e) {
	print "Erreur: " . $e->getMessage() . "<br/>";
	die();
}
// $db->exec("INSERT INTO chat (id, user_id, msg, time) VALUES (NULL, '123', 'test', CURRENT_TIMESTAMP)");
?>
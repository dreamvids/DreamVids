<?php
session_start(); // START THE SESSION
$lang_path = '../';
include '../includes/bdd.class.php';
include '../includes/functions.php';
include '../classes/LoggedUser.php';
include '../includes/tasks.php';
require_once('db.php'); // CONNECT TO THE DATABASE USING PDO

if(isset($session)){ // DREAMVID'S USER
	$user_id = $session->getId(); // ID OF DREAMVID'S USER
	$pseudo = $session->getName(); // PSEUDO OF DREAMVID'S USER
} else { // ANONYME USER
	if(isset($_SESSION['user_id'])) $user_id = $_SESSION['user_id']; // ID OF AN ANONYME
	else $user_id = $_SESSION['user_id'] = '-'.uniqid(); // ID OF AN ANONYME
}

if(isset($_POST['getMsg']) || isset($_POST['message'])){

	$ip = $_SERVER['REMOTE_ADDR'];
	$req = $db->query("SELECT time FROM chat_banned WHERE ip = '$ip' OR user_id= '$user_id' ORDER BY time DESC");
	$banned = $req->fetch();
	if(!$banned OR ($banned['time'] != -1 && $banned['time'] < time())){
		if(isset($_COOKIE['banned'])){
			setcookie('banned', "", time() - 3600);
		}
		if(isset($_POST['getMsg'])){
			$last = time() - 5;
			$messages = $db->query("SELECT * FROM chat WHERE time > '$last' AND user_id!='$user_id' ORDER BY id");
			foreach ($messages as $message) {
				if(strstr($message['user_id'], '-')){
					$pseudo = "Anonyme-".substr($message['user_id'], -5);
					echo "
						<div class=\"message\">
							<img src=\"http://lorempixel.com/20/20/cats/?". $message['user_id'] ."\" class=\"avatar\" /><div class=\"pseudo\">" . $pseudo . "</div> ";
							echo (isset($session) && ($session->getRank() == $config['rank_modo'] || $session->getRank() == $config['rank_adm'])) ? "<div style=\"display:none;\" class=\"admin\"><a href=\"#\" onclick=\"ban('" . $message['user_id'] . "','" . $pseudo . "','" . $message['ip'] . "','temp')\">Ban 5 minutes</a> | <a href=\"#\" onclick=\"ban('" . $message['user_id'] . "','" . $pseudo . "','" . $message['ip'] . "','def')\">Ban définitif</a></div>" : '';
							echo htmlspecialchars($message['message']) . "
						</div>
					";
				} else {
					$user = new User($message['user_id']); // REMOTE DREAMVID'S USER
					echo "
						<div class=\"message\">
							<a href=\"http://dreamvids.fr/@" . $user->getUsername() . "\" target=\"_blank\"><img src=\"../" . $user->getAvatarPath() . "\" class=\"avatar\" /><div class=\"pseudo\">" . secure($user->getUsername() ) . "</div></a>";
							echo (isset($session) && ($session->getRank() == $config['rank_modo'] || $session->getRank() == $config['rank_adm'])) ? "<div style=\"display:none;\" class=\"admin\"><a href=\"#\" onclick=\"ban('" . $message['user_id'] . "','" . secure($user->getUsername() ) . "','" . $message['ip'] . "','temp')\">Ban 5 minutes</a> | <a href=\"#\" onclick=\"ban('" . $message['user_id'] . "','" . secure($user->getUsername() ) . "','" . $message['ip'] . "','def')\">Ban définitif</a></div>" : '';
							echo secure($message['message']) . "
						</div>
					";
				}
			}
		}
		if(isset($_POST['message'])){
			$message = $_POST['message'];
			if($message != '' && $message != ' '){
				$req = $db->prepare("INSERT INTO chat(user_id, message, ip, time) VALUES(:user_id, :message, :ip, :time)");
				$req->execute(array(
					'user_id' => $user_id,
					'message' => $message,
					'ip' => $_SERVER['REMOTE_ADDR'],
					'time' => time()
				));
				if(!isset($session)){
					$pseudo = 'Moi';
					echo "
						<div class=\"message me\">
							<img src=\"http://lorempixel.com/20/20/cats/?". $_SESSION['user_id'] ."\" class=\"avatar\" /><div class=\"pseudo\">" . $pseudo . "</div>
							" . htmlspecialchars($message) . "
						</div>
					";
				} else {
					echo "
						<div class=\"message me\">
							<a href=\"http://dreamvids.fr/@" . $pseudo . "\" target=\"_blank\"><img src=\"../" . $session->getAvatarPath() . "\" class=\"avatar\" /><div class=\"pseudo\">" . $pseudo . "</div></a>
							" . htmlspecialchars($message) . "
						</div>
					";
				}
			} else {
				echo '<div class="alert alert-danger">Merci de ne pas envoyer de messages vides</div>';
			}
		}
	} else {
		if(!isset($_COOKIE['banned'])){
			echo "<div class=\"alert alert-danger\">Vous êtes banni</div>";
		}
		setcookie('banned', 1);
	}
}

if(isset($_POST['user_id']) && isset($_POST['user_name']) && isset($_POST['ip']) && isset($_POST['type'])){
	if(isset($user) && ($session->getRank() == $config['rank_modo'] || $session->getRank() == $config['rank_adm'])){
		$ip = $_POST['ip'];
		$user_id = $_POST['user_id'];
		$user_name = $_POST['user_name'];
		if($_POST['type'] == 'temp'){
			$time = time() + 300;

			$req = $db->prepare("INSERT INTO chat_banned(user_id, ip, time) VALUES(:user_id, :ip, :time)");
			$req->execute(array(
				'user_id' => $user_id,
				'ip' => $ip,
				'time' => $time
			));

			echo '<div class="alert alert-success">' . $user_name . ' a été banni 5 minutes</div>';
		} elseif($_POST['type'] == 'def') {
			$time = -1;

			$req = $db->prepare("INSERT INTO chat_banned(user_id, ip, time) VALUES(:user_id, :ip, :time)");
			$req->execute(array(
				'user_id' => $user_id,
				'ip' => $ip,
				'time' => $time
			));
			
			echo '<div class="alert alert-success">' . $user_name . ' a été banni définitivement</div>';
		}
	}
}
?>
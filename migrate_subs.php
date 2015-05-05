<?php
DEFINE('HOST', 'localhost'); 	//you know what these are 
DEFINE('DB', 'dreamvids_v2'); 
DEFINE('USER', 'root');
DEFINE('PASS', '');
DEFINE('DOIT', true); //For testing let it at false

	echo "#This script will not modify other tables than `subscriptions`.\n\n";
if(!DOIT){
	echo "#Won't do anything : DOIT at false\n\n";
}

$create_table = 'DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` INT(11) NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `channel_id` varchar(255) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;';


$pdo = new PDO('mysql:host='.HOST.';dbname='.DB, USER, PASS); //connect

if(DOIT){
	$pdo->query($create_table); //Init table
}

$stmt = $pdo->query('SELECT id, subscriptions FROM `users`'); //On recupere tout depuis user

$request = "INSERT IGNORE INTO `subscriptions` (`user_id`, `channel_id`, `timestamp`) VALUES"; //Début de requette

while($current = $stmt->fetch(PDO::FETCH_ASSOC)){ //On recupere chaque user un par un

	$subs = explode(';',trim($current['subscriptions'], ';')); //On recupere les subs
	$user_id = $current['id']; //Le user_id
	$done_for_this_user = [];
	foreach($subs as $k => $sub){ //Pour chaque subscribe
		if($sub =='' || in_array($sub, $done_for_this_user)){ //Si c'est vide "for some reason" on ignore ou qu'il est dupliqué'
			continue;
		}
		//sinon on ajoute une entrée à la requette du début;
		$request .= "\n($user_id, '$sub', ".time()."),";
		$done_for_this_user[] = $sub;
	}	
}
$stmt->closeCursor(); //On 'ferme le fetch'
 
$request = trim($request, ',') . ';'; //on enleve la derniere , et on remplace par ;
echo $request;
	
if(DOIT){
	$pdo->query($request); //Execute INSTER INTO...
	$pdo->query('DELETE FROM `subscriptions` WHERE `channel_id` NOT IN(SELECT `id` FROM `users_channels`)'); //Clear unexisting channels
}

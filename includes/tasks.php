<?php
$bdd = new BDD();
$email_actif = true;
if (isset($_COOKIE['SESSID']) )
{
	$reponse = $bdd->select("user_id", "users_sessions", "WHERE session_id='".$bdd->real_escape_string($_COOKIE['SESSID'])."'");
	$donnees = $bdd->fetch_array($reponse);
	
	if ($bdd->num_rows($reponse) > 0)
	{
		$session = new LoggedUser($donnees['user_id'], $bdd->real_escape_string($_COOKIE['SESSID']) );
	}
	else
	{
		setcookie("SESSID", "", -1);
	}
}

$bdd->delete("users_sessions", "WHERE expiration < '".tps()."'");
$bdd->delete("chat", "WHERE time + 3600 < '".tps()."'");

$reponse = $bdd->select("*", "config");
echo mysql_error();
while ($donnees = $bdd->fetch_array($reponse) )
{
	$config[$donnees['key']] = $donnees['value'];
}

if (isset($_COOKIE['lang']) )
{
	switch ($_COOKIE['lang'])
	{
		case 'fr':
			require $lang_path.'/lang/lang_fr.php';
			define('LANG', 'fr');
		break;
		
		default:
			require $lang_path.'/lang/lang_fr.php';
			define('LANG', 'en');
		break;
	}
}
else
{
	$language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	$language = $language{0}.$language{1};
	switch ($language)
	{
		case 'fr':
			require $lang_path.'/lang/lang_fr.php';
			define('LANG', 'fr');
		break;
		
		default:
			require $lang_path.'/lang/lang_fr.php';
			define('LANG', 'en');
		break;
	}
}
$l = array('fr' => 0);

$bdd->close();
?>
<?php
class Reg
{
	public static function EmailExist($email)
	{
		$bdd = new BDD();
		$data = $bdd->fetch_array($bdd->count("nb_mail", "users", "WHERE email='".$bdd->real_escape_string($email)."'") );
		$bdd->close();
		return ($data['nb_mail'] > 0);
	}
	
	public static function UsernameExist($username)
	{
		$bdd = new BDD();
		$data = $bdd->fetch_array($bdd->count("nb_user", "users", "WHERE username='".$bdd->real_escape_string($username)."'") );
		$bdd->close();
		return ($data['nb_user'] > 0);
	}
	
	public static function register($email, $username, $pass)
	{
		global $config;
		$bdd = new BDD();
		$bdd->insert("users", "'', '".$bdd->real_escape_string($username)."', '".$bdd->real_escape_string($email)."', '".sha1($pass)."', '', '', '', '".tps()."', '".$_SERVER['REMOTE_ADDR']."', '".$_SERVER['REMOTE_ADDR']."', '".$config['rank_mbr']."'");
		$bdd->close();
	}
}
?>
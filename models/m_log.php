<?php
class Log
{
	public static function userExist($username)
	{
		$bdd = new BDD();
		$data = $bdd->fetch_array($bdd->count("nb_user", "users", "WHERE username='".$bdd->real_escape_string($username)."'") );
		$bdd->close();
		return ($data['nb_user'] == 1);
	}
	
	public static function getPassFromUsername($username)
	{
		$bdd = new BDD();
		$data = $bdd->fetch_array($bdd->select("pass", "users", "WHERE username='".$bdd->real_escape_string($username)."'") );
		$bdd->close();
		return $data['pass'];
	}
	
	public static function connect($username, $remember)
	{
		$remember = ($remember == 'remember') ? 1 : 0;
		$sessid = md5(uniqid() );
		$expiration = ($remember) ? tps() + 365*86400 : tps() + 15*60;
		$bdd = new BDD();
		$data = $bdd->fetch_array($bdd->select("id", "users", "WHERE username='".$username."'") );
		$bdd->insert("users_sessions", "'".$data['id']."', '".$sessid."', '".$expiration."', '".$remember."'");
		$bdd->close();
		setcookie('SESSID', $sessid, $expiration);
	}
	
	public static function logout($user_id)
	{
		$bdd = new BDD();
		$bdd->delete("users_sessions", "WHERE user_id='".$bdd->real_escape_string($user_id)."'");
		$bdd->close();
		setcookie("SESSID", '', -1);
	}
}
?>
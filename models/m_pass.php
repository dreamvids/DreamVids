<?php
class Pass
{
	public static function getPassFromId($id)
	{
		$db = new BDD();
		$rep = $db->select("pass", "users", "WHERE id='".$db->real_escape_string($id)."'");
		$data = $db->fetch_array($rep);
		$db->close();
		return $data['pass'];
	}
}
?>
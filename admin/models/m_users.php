<?php
class AdminUsers
{
	public static function fetchAll($page, $nb_users_page)
	{
		$first = ($page - 1) * $nb_users_page;
		$db = new BDD();
		$rep = $db->select("id", "users", "ORDER BY username LIMIT ".$first.", ".$nb_users_page);
		$users = array();
		while ($data = $db->fetch_array($rep) )
		{
			$users[] = new User($data['id']);
		}
		$db->close();
		return $users;
	}
	
	public static function delete($id)
	{
		$db = new BDD();
		$db->delete("users", "WHERE id='".$db->real_escape_string($id)."'");
		$db->close();
	}
	
	public static function usersCount()
	{
		$db = new BDD();
		$rep = $db->num_rows($db->select("id", "users") );
		$db->close();
		return $rep;
	}
}
?>
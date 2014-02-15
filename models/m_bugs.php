<?php
class Bugs
{
	public static function report($bug, $url, $user_id)
	{
		$db = new BDD();
		$db->insert("bugs", "'', '".$user_id."', '".$db->real_escape_string($_POST['bug'])."', '".$db->real_escape_string(@$_POST['url'])."', '0'");
		echo $db->error();
		$db->close();
	}
	
	public static function getFromPageNumber($page)
	{
		$nb_bugs_page = 20;
		$first = ($page - 1) * $nb_bugs_page;
		$db = new BDD();
		$rep = $db->select("*", "bugs", "ORDER BY id DESC LIMIT ".$first.", ".$nb_bugs_page);
		echo $db->error();
		$db->close();
		return MVCArray("bugs", $rep);
	}
	
	public static function setResolution($id, $resolution, $page)
	{
		$db = new BDD();
		$db->update("bugs", "resolution='".$resolution."'", "WHERE id='".$db->real_escape_string($id)."'");
		$db->close();
		header('location:index.php?page=bugs&p='.$page.'#bug-'.$id);
		exit();
	}
	
	public static function delete($id, $page)
	{
		$db = new BDD();
		$db->delete("bugs", "WHERE id='".$db->real_escape_string($id)."'");
		$db->close();
		header('location:index.php?page=bugs&p='.$page.'#bug-'.($id - 1) );
		exit();
	}
}
?>
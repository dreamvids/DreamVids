<?php
class Contributors
{
	public static function fetchAll()
	{
		$db = new BDD();
		$rep = $db->select("*", "contributors");
		$db->close();
		return MVCArray("contributors", $rep, false);
	}
}
?>
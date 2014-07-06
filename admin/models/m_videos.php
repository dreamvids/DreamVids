<?php
class AdminVideos
{
	public static function fetchAll($page, $nb_vids_page)
	{
		$first = ($page - 1) * $nb_vids_page;
		$db = new BDD();
		$rep = $db->select("id", "videos", "ORDER BY timestamp DESC LIMIT ".$first.", ".$nb_vids_page);
		$vids = array();
		while ($data = $db->fetch_array($rep) )
		{
			$vids[] = Video::get($data['id']);
		}
		$db->close();
		return $vids;
	}
	
	public static function videosCount()
	{
		$db = new BDD();
		$rep = $db->num_rows($db->select("id", "videos") );
		$db->close();
		return $rep;
	}
}
?>
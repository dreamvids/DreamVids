<?php
class Vidslist
{
	public static function getDiscoverVideos($nb)
	{
		$db = new BDD();
		$rep = $db->select("id", "users", "ORDER BY subscribers LIMIT 0, ".$nb);
		$vids = array();
		while ($data = $db->fetch_array($rep) )
		{
			$vid = $db->fetch_array($db->select("id", "videos", "WHERE user_id='".$data['id']."' ORDER BY timestamp DESC LIMIT 0, 1") );
			$vids[] = Video::get($vid['id']);
		}
		$db->close();
		return $vids;
	}
	
	public static function getNewVideos($nb)
	{
		$db = new BDD();
		$rep = $db->select("id", "videos", "ORDER BY timestamp DESC LIMIT 0, ".$nb);
		$vids = array();
		while ($data = $db->fetch_array($rep) )
		{
			$vids[] = Video::get($data['id']);
		}
		$db->close();
		return $vids;
	}
	
	public static function getSubscriptionsVideos($nb)
	{
		
	}
}
?>
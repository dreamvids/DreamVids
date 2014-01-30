<?php
class Vidslist
{
	private $session;
	
	public function __construct()
	{
		$this->session = @$GLOBALS['session'];
	}
	
	public function getDiscoverVideos($nb)
	{
		$db = new BDD();
		$rep = $db->select("id", "users", "ORDER BY subscribers LIMIT 0, ".$nb);
		$vids = array();
		while ($data = $db->fetch_array($rep) )
		{
			$req = $db->select("id", "videos", "WHERE user_id='".$data['id']."' AND visibility=2 ORDER BY timestamp DESC LIMIT 0, 1");
			if ($db->num_rows($req) > 0)
			{
				$vid = $db->fetch_array($req);
				$vids[] = Video::get($vid['id']);
			}
		}
		$db->close();
		return $vids;
	}
	
	public function getNewVideos($nb)
	{
		$db = new BDD();
		$rep = $db->select("id", "videos", "WHERE visibility=2 ORDER BY timestamp DESC LIMIT 0, ".$nb);
		$vids = array();
		while ($data = $db->fetch_array($rep) )
		{
			$vids[] = Video::get($data['id']);
		}
		$db->close();
		return $vids;
	}
	
	public function getSubscriptionsVideos($nb)
	{
		$vids = array();
		$sess_subs = $this->session->getSubscriptions();
		unset($sess_subs[0]);
		if (@count($sess_subs) >= 1)
		{
			$db = new BDD();
			$rep = $db->select("id", "videos", "WHERE user_id IN (".implode(',', $sess_subs).") AND visibility=2 ORDER BY timestamp DESC LIMIT 0, ".$nb);
			
			echo $db->error();
			while ($data = $db->fetch_array($rep) )
			{
				$vids[] = Video::get($data['id']);
			}
			$db->close();
		}
		return $vids;
	}
	
	public function getSearchVideos($search)
	{
		$vids = array();
		$db = new BDD();
		$rep = $db->select("id", "videos", "WHERE title LIKE '%".$db->real_escape_string($search)."%' OR tags LIKE '%".$db->real_escape_string($search)."%'");
		while ($data = $db->fetch_array($rep) )
		{
			$vids[] = Video::get($data['id']);
		}
		$db->close();
		return $vids;
	}
	
	public function getSubscriptions()
	{
		$db = new BDD();
		$subs = array();
		$sess_subs = $this->session->getSubscriptions();
		unset($sess_subs[0]);
		foreach ($sess_subs as $sub)
		{
			$subs[] = new User($sub);
		}
		return $subs;
	}
}
?>
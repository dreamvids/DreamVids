<?php
class Vidslist
{
	private $session;
	
	public function __construct()
	{
		$this->session = $GLOBALS['session'];
	}
	
	public function getDiscoverVideos($nb)
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
	
	public function getNewVideos($nb)
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
	
	public function getSubscriptionsVideos($nb)
	{
		$vids = array();
		$sess_subs = $this->session->getSubscriptions();
		unset($sess_subs[0]);
		if (@count($sess_subs) >= 1)
		{
			$db = new BDD();
			$rep = $db->select("id", "videos", "WHERE user_id IN (".implode(',', $sess_subs).") ORDER BY timestamp DESC LIMIT 0, ".$nb);
			
			echo $db->error();
			while ($data = $db->fetch_array($rep) )
			{
				$vids[] = Video::get($data['id']);
			}
			$db->close();
		}
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
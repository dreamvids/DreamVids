<?php
class Ajax
{
	private $session;
	private $user_id;
	
	public function __construct()
	{
		$this->session = $GLOBALS['session'];
		$this->user_id = $this->session->getId();
	}
	
	public function like($vid_id)
	{
		$db = new BDD();
		$data = $db->num_rows($db->select("user_id", "videos_votes", "WHERE obj_id='".$db->real_escape_string($vid_id)."' AND type='video' AND user_id='".$db->real_escape_string($this->user_id)."'") );
		if ($data == 0)
			$db->insert("videos_votes", "'.$this->user_id.', 'video', '".$db->real_escape_string($vid_id)."', 'like'");
		$db->close();
	}
	
	public function dislike($vid_id)
	{
		$db = new BDD();
		$data = $db->num_rows($db->select("user_id", "videos_votes", "WHERE obj_id='".$db->real_escape_string($vid_id)."' AND type='video' AND user_id='".$db->real_escape_string($this->user_id)."'") );
		if ($data == 0)
			$db->insert("videos_votes", "'.$this->user_id.', 'video', '".$db->real_escape_string($vid_id)."', 'dislike'");
		$db->close();
	}
	
	public function likeComment($com_id)
	{
		$db = new BDD();
		$data = $db->num_rows($db->select("user_id", "videos_votes", "WHERE obj_id='".$db->real_escape_string($com_id)."' AND type='comment' AND user_id='".$db->real_escape_string($this->user_id)."'") );
		if ($data == 0)
			$db->insert("videos_votes", "'.$this->user_id.', 'comment', '".$db->real_escape_string($com_id)."', 'like'");
		$db->close();
	}
	
	public function dislikeComment($com_id)
	{
		$db = new BDD();
		$data = $db->num_rows($db->select("user_id", "videos_votes", "WHERE obj_id='".$db->real_escape_string($com_id)."' AND type='comment' AND user_id='".$db->real_escape_string($this->user_id)."'") );
		if ($data == 0)
			$db->insert("videos_votes", "'.$this->user_id.', 'comment', '".$db->real_escape_string($com_id)."', 'dislike'");
		$db->close();
	}
	
	public function subscribe($dr_id)
	{
		if (!in_array($dr_id, $this->session->getSubscriptions() ) )
		{
			$this->session->setSubscriptions($dr_id);
			$this->session->saveDataToDatabase();
			$dreamer = new User($dr_id);
			$dreamer->setSubscribers();
			$dreamer->saveDataToDatabase();
		}
	}
	
	public function unsubscribe($dr_id)
	{
		if (in_array($dr_id, $this->session->getSubscriptions() ) )
		{
			$this->session->setSubscriptions($dr_id, false);
			$this->session->saveDataToDatabase();
			$dreamer = new User($dr_id);
			$dreamer->setSubscribers(false);
			$dreamer->saveDataToDatabase();
		}
	}
}
?>
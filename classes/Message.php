<?php

class Message {

	private $id = 'nope';
	private $sender;
	private $recipient;
	private $content;

	public static function get($messageId) {
		$instance = new self();
		$instance->loadFromDB($messageId);

		return $instance;
	}

	public static function create($content, $sender, $recipient) {
		$instance = new self();

		$instance->id = self::generateId(6);
		$instance->sender = $sender;
		$instance->recipient = $recipient;
		$instance->content = $content;

		$instance->writeToDB();

		return $instance;
	}

	private function loadFromDB($id) {
		$db = new BDD();
		$res = $db->select("*", "messages", "WHERE id='".$id."'");

		while($row = $db->fetch_array($res)) {
			$this->id = $row['id'];
			$this->sender = $row['sender'];
			$this->recipient = $row['recipient'];
			$this->content = $row['content'];
		}
	}

	private function writeToDB() {
		$db = new BDD();
		$req = $db->insert('messages', "'', '".$this->id."', '".$this->sender."', '".$this->recipient."', '".$this->content."', '".tps()."'");
	}

	public function getId() {
		return $this->id;
	}

	public function getSender() {
		return $this->sender;
	}

	public function getSendersName() {
		return User::getNameById($this->sender);
	}

	public function getRecipient() {
		return $this->recipient;
	}

	public function getRecipientsName() {
		return User::getNameById($this->recipient);
	}

	public function getContent() {
		return $this->content;
	}

	public function isValid() {
		return $this->id != 'nope';
	}


	// utility functions
	public static function generateId($length) {
		$db = new BDD();
		$rows = 1;
		$id = 0;
		while($rows != 0) {
			$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $id = '';
	
		    for ($i = 0; $i < $length; $i++) {
		        $id .= $chars[rand(0, strlen($chars) - 1)];
		    }
			$res0 = $db->select("id", "messages", "WHERE id='".$id."'");
			$rows = $db->num_rows($res0);
		}

	    return $id;
	}

	public static function getReceivedMessages($userId, $number) {
		$db = new BDD();
		$res = $db->select("*", "messages", "WHERE recipient='".$userId."' ORDER BY timestamp DESC LIMIT ".$number);
		$messages = array();

		$i = 0;
		while ($row = $db->fetch_array($res)) {
			$messages[$i] = Message::get($row['id']);
			$i++;
		}

		return $messages;
	}

	public static function getLastMessageFrom($sender, $recipient) {
		$msg = null;
		$db = new BDD();
		$res = $db->select("*", "messages", "WHERE sender='".$sender."' AND recipient='".$recipient."' ORDER BY timestamp DESC LIMIT 1");

		while($row = $db->fetch_array($res)) {
			$msg = self::get($row['id']);
		}

		return $msg;
	}

}

?>
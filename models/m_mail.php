<?php

class Mail {

	public static function getLastReceivedMessages($userId, $number) {
		return Message::getReceivedMessages($userId, $number);
	}

	public static function getLastMessageFromTo($from, $to) {
		return Message::getLastMessageFrom($from, $to);
	}

	public static function getAllUsers() {
		$users = array();

		$db = new BDD();
		$res = $db->select("*", "users");

		$i = 0;
		while($row = $db->fetch_array($res)) {
			$users[$i] = new User($row['id']);
			$i++;
		}

		return $users;
	}

	public static function sendMessageTo($senderId, $receiverId, $message) {
		Message::create($message, $senderId, $receiverId);
	}

}

?>
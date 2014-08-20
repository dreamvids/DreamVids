<?php

class Message extends ActiveRecord\Model {

	static $table_name = 'messages';

	public static function sendNew($sender, $conversation, $content) {
		$id = Message::generateId(6);
		$timestamp = Utils::tps();

		$message = Message::create(array(
			'id' => $id,
			'sender_id' => $sender,
			'conversation_id' => $conversation,
			'content' => $content,
			'timestamp' => $timestamp
		));

		ChannelAction::create(array(
			'id' => ChannelAction::generateId(6),
			'channel_id' => User::find($sender)->getMainChannel()->id,
			'recipients_ids' => Conversation::find($conversation)->members_ids,
			'type' => 'message',
			'target' => $conversation,
			'timestamp' => $timestamp
		));

		return $message;
	}

	public static function generateId($length) {
		$idExists = true;

		while($idExists) {
			$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$id = '';
		
			for ($i = 0; $i < $length; $i++) {
				$id .= $chars[rand(0, strlen($chars) - 1)];
			}

			$idExists = Message::exists(array('id' => $id));
		}

		return $id;
	}

}
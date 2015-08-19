<?php

require_once MODEL.'message.php';

class Conversation extends ActiveRecord\Model {

	static $table_name = 'conversations';

	public function containsChannel($channel) {
		if(is_object($channel)) {
			$channelId = (string)$channel->id;
			return strpos($this->members_ids, ';'.$channelId.';') !== false;
		}

		return false;
	}

	public function isUserAllowed($user) {
		if(is_object($user)) {
			foreach($user->getOwnedChannels() as $channel) {
				if($this->containsChannel($channel))
					return true;
			}
		}

		return false;
	}

	public function removeChannel($channel) {
		if(is_object($channel)) {
			$members_ids = str_replace($channel->id.';', '', $this->members_ids);
			$this->members_ids = $members_ids;
			$this->save();
		}
	}

	public function getMemberChannelsName() {
		$names = array();
		$membersStr = $this->members_ids;

		if($this->isTicketConv()){
			$tech_channel = $this->getTechChannel();
			$tech_user = $this->getTechUser();
		}

		if(Utils::stringStartsWith($membersStr, ';'))
				$membersStr = substr_replace($membersStr, '', 0, 1);
		if(Utils::stringEndsWith($membersStr, ';'))
			$membersStr = substr_replace($membersStr, '', -1);

		if(strpos($membersStr, ';') !== false) {
			$membersIds = explode(';', $membersStr);

			foreach($membersIds as $memberId) {
				if(UserChannel::exists($memberId)) {
					if(isset($tech_channel) && $tech_channel->id == $memberId){
						$names[] = StaffContact::getShownName($tech_user);
					}else{
						$names[] = UserChannel::find($memberId)->name;
					}
				}
			}
		}

		return $names;
	}

	public function getThumbnail() {
		$avatar = Config::getValue_('default-avatar');

		if(file_exists($this->thumbnail) || ($isUrl = Utils::isUrlValid($this->thumbnail)))
			$avatar = isset($isUrl) ? $this->thumbnail : WEBROOT.$this->thumbnail;
		else if(strpos($this->thumbnail, WEBROOT) !== false)
			$avatar = $this->thumbnail;

		return $avatar;
	}
	
	public function getMessages() {
		return Message::all(array('conditions' => array('conversation_id' => $this->id), 'order' => 'timestamp asc'));
	}

	public function getLastMessage() {
		return Message::last(array('conditions' => array('conversation_id' => $this->id), 'order' => 'timestamp asc'));
	}
	
	public function isTicketConv(){
		return $this->is_ticket;
	}
	
	public function getTechChannel(){
		if($this->is_ticket){
			return UserChannel::find_by_owner_id($this->tech_id);
		}else{
			return null;
		}
	}
	
	public function getTechUser(){
		return User::find_by_id($this->tech_id);
	}
	
	public static function getByUser($user) {
		$conversations = array();

		if(is_object($user)) {
			foreach($user->getOwnedChannels() as $channel) {
				$conversationsTemp = Conversation::find_by_sql("SELECT * FROM conversations WHERE members_ids LIKE '%;".$channel->id.";%'");
				$conversations = array_merge($conversations, $conversationsTemp);
			}
		}

		return $conversations;
	}

	public static function getByChannel($channel) {
		$conversations = array();

		if(is_object($channel))
			$conversations = Conversation::find_by_sql("SELECT * FROM conversations WHERE members_ids LIKE '%;".$channel->id.";%'");

		return $conversations;
	}

	public static function createNew($object, $creator, $members, $is_ticket = false, $tech_id = null) {
		
		if(!$is_ticket){
			$thumnail = $creator->getAvatar();
		}else{
			$thumnail = StaffContact::getImageName(User::find_by_id($tech_id));
		}
		
		$conv = Conversation::create(array(
			'id' => Conversation::generateId(6),
			'object' => $object,
			'members_ids' => $members,
			'thumbnail' => $thumnail,
			'is_ticket' => $is_ticket,
			'tech_id' => $tech_id
		));
		return $conv->id;
	}

	public static function generateId($length) {
		$idExists = true;

		while($idExists) {
			$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$id = '';
		
			for ($i = 0; $i < $length; $i++) {
				$id .= $chars[rand(0, strlen($chars) - 1)];
			}

			$idExists = Conversation::exists(array('id' => $id));
		}

		return $id;
	}

}
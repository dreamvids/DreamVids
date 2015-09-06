<?php
require_once MODEL . 'user.php';
require_once MODEL. 'pushbullet.php';
class StaffNotification extends ActiveRecord\Model {

	static $table_name = 'staff_notifications';
	
	public function getType(){
		return $this->type;
	}
	
	public function getAssociatedUsers(){
		$fields = ['one', 'two'];
		$users = [];
		foreach($fields as $field){
			if($this->{'id_' . $field} != null && $this->{'id_' . $field} != ''){
				if(User::exists()){
					$users[] = User::find($this->{'id_' . $field});
				}else{
					$users[] = null;
				}
			}else{
				$users[] = null;
			}
		}
		return $users;
	}
	
	public function getAssociatedValue($className){
		if(class_exists($className)){
			if($className::exists($this->value)){
				return $className::find($this->value);
			}else{
				return null;
			}
		}else{
			return null;
		}
	}
	
	public function getContent(){
		$content = "";
		$users = $this->getAssociatedUsers();
		$username1 = is_object($users[0]) ? htmlspecialchars(StaffContact::getShownName($users[0])) : '[deleted]';
		$username2 = is_object($users[1]) ? htmlspecialchars(StaffContact::getShownName($users[1])) : '[deleted]';
		
		switch($this->getType()){
			case 'news' : 
				$content = "Nouvelle news de $username1";
				break;
			case 'rank' :
				$content = $username1 . " a été mis au rang " . Utils::rankToName($this->value)[0] . " par $username2";
				break;
			case 'ticket':
				$content = "Ticket #$this->value en attente de réponse [user : $username1]";
				break;
			case 'ticket_level_change' :
				$ticket = $this->getAssociatedValue('Ticket');
				$tick_level  = is_object($ticket) ? htmlspecialchars($ticket->getLabel()) : '[deleted]';
				$content = "Ticket #$this->value assigné à $tick_level par $username1";
				break;
			case 'suspend_video' : 
				$video = $this->getAssociatedValue('Video');
				$vid_title = is_object($video) ? htmlspecialchars($video->title) : '[deleted]';
				$content = "$username1 a suspendu la vidéo $vid_title";
			break;
		}
		
		return $content;
	}
	
	public function getIcon(){
		switch($this->getType()){
			case 'new' :
			case 'newspaper' :
			case 'news' : return 'newspaper-o';
			break;
			case 'rank' : return 'users';
			break;
			case 'ticket' :
			case 'ticket_level_change' : return 'ticket';
			break;
			case 'suspend_video' : return 'video-camera';
			break;
			default : return $this->getType();
		}
	}
	
	public function getLevel(){
		return ($this->level != null && $this->level != '') ? 'list-group-item-' . $this->level : '';
	}
	
	public function canSee($user){
		return Utils::getRankArray($user)[$this->viewers];
	}
	
	public static function getInternStaffNotifications($limit = 20){
		$notifs = self::find('all', ['limit' => $limit, 'order' => 'timestamp DESC']);
		return $notifs;
	}
	
	public static function createNotif($type, $id_one = null, $id_two = null, $value = null, $level = '', $viewers = 'team_or_more'){
			
			
		$staff_notif = StaffNotification::create([
				'type' => $type,
				'id_one' => $id_one,
				'id_two' => $id_two,
				'value' => $value,
				'viewers' => $viewers,
				'level' => $level,
				'timestamp' => Utils::tps()
			]);
			$emails = [];
			foreach(User::getTeam() as $user){
				if(Utils::getRankArray($user)[$viewers]){
					if(!is_null($user->details->push_bullet_email) && $user->details->push_bullet_email != '' && 
						!is_null($user->details->push_bullet_email) && $user->details->enable_push_bullet == 1){
						$emails[] = $user->details->push_bullet_email;
					}
				}
			}
			$notif = new PushBulletNotification('Dreamvids', $staff_notif->getContent(), $emails);
			$notif->send();
	}
}
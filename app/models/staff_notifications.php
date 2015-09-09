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
			if($this->{'id_' . $field} != null && $this->{'id_' . $field} != '' && $this->{'id_' . $field} != 0){
				if(User::exists($this->{'id_' . $field})){
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
			case 'flag_video' : 
				$video = $this->getAssociatedValue('Video');
				$vid_title = is_object($video) ? htmlspecialchars($video->title) : '[deleted]';
				$content = "$username1 a signalé la vidéo $vid_title";
			break;
			case 'private' :
				$content = "Message de $username1 : $this->value";
			break;
		}
		
		return $content;
	}
	/**
	 * Return the relative path to the target of the notification 
	 *
	 */
	public function getLink(){
		switch($this->getType()){
			case 'news' : 
				return 'admin/';
				break;
			case 'rank' :
				return 'admin/settings/users';
				break;
			case 'ticket':
			case 'ticket_level_change' :
				return 'admin/tickets';
				break;
			case 'flag_video' : 
			case 'suspend_video' : 
				return 'watch/'.$this->value;
				break;
			case 'private' : return 'admin/notifications';
				break;
			default : return null;
				break;
		}
	}
	
	public function getIcon(){
		switch($this->getType()){
			case 'new' :
			case 'newspaper' :
			case 'news' : 
				return 'newspaper-o';
				break;
			case 'rank' : 
				return 'users';
				break;
			case 'ticket' :
			case 'ticket_level_change' : 
				return 'ticket';
				break;
			case 'flag_video' :
			case 'suspend_video' : 
				return 'video-camera';
				break;
			case 'private' :
				return 'comment';
			break;
			default : return $this->getType();
		}
	}
	
	public function getLevel(){
		return ($this->level != null && $this->level != '') ? 'list-group-item-' . $this->level : '';
	}
	
	public function canSee($user){
		return Utils::getRankArray($user)[$this->viewers] && (!$this->isPrivate() || $this->id_two == $user->id);
	}
	
	public function isPrivate(){
		return $this->type == 'private';
	}
	
	public function isTicketChangeVisible($user){
		return $this->type != 'ticket_level_change' || (in_array($this->getAssociatedValue('Ticket')->ticket_levels_id, $user->getAssignedLevelsIds()) || $user->isAdmin());
	}
	public static function getInternStaffNotifications($limit = 20){
		$notifs = self::find('all', ['limit' => $limit, 'order' => 'timestamp DESC']);
		$notifs = array_filter($notifs, function($k) {
									    return $k->isTicketChangeVisible(Session::get());
									});
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
			$title = 'DreamVids';
			$sub_title = '';
			$is_link = !is_null($staff_notif->getLink());
			$link_url = "http://".@$_SERVER['HTTP_HOST'].WEBROOT.$staff_notif->getLink();
			foreach(User::getTeam() as $user){
				$content = $staff_notif->getContent();
				if(Utils::getRankArray($user)[$viewers] && self::isEnabled($user)){
					if(!is_null($user->details->push_bullet_email) && $user->details->push_bullet_email != ''){
							switch($type){
								case 'ticket_level_change' : 
									$ticket = $staff_notif->getAssociatedValue('Ticket');
									$sub_title = 'Tickets';
									if(in_array($ticket->ticket_levels_id, $user->getAssignedLevelsIds()) || $user->isAdmin()){
										$emails[] = $user->details->push_bullet_email;
									}
								break;
								case 'ticket' :
										$sub_title = 'Tickets';
										$emails[] = $user->details->push_bullet_email;
									break;
								case 'news' : 
									$sub_title = 'News';
									$emails[] = $user->details->push_bullet_email;
								break;
								case 'private' : 
										$sub_title = "Message privé";
										$content = $staff_notif->value;
										if($staff_notif->id_two == $user->id){
											$emails[] = $user->details->push_bullet_email;
										}
								break;
								default: 
									$emails[] = $user->details->push_bullet_email;
								break;
							}
					}
				}
			}
			
			$notif = new PushBulletNotification($title . ($sub_title != '' ? (' - ' . $sub_title) : ''), $content, $emails, $is_link, $link_url);
			$notif->send();
	}
	
	public static function isEnabled($user){
		return $user->isNotificationEnabled();
	}
}
<?php
require_once MODEL . 'ticket_levels.php';

class Ticket extends ActiveRecord\Model {

	static $table_name = 'tickets';
	static $belongs_to = [
		['ticket_levels'],
		['UserTicketsCapability']
	];
	public static function getSize($user = null) {
		if($user instanceof User){
			return count($user->getAssignedTickets());
		}else{
			return self::count();
		}
	}
	
	public function getLabel(){
		return $this->ticket_levels->label;
	}
	
}
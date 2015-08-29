<?php
require_once MODEL . 'ticket_levels.php';

class Ticket extends ActiveRecord\Model {

	static $table_name = 'tickets';
	static $belongs_to = [
		['ticket_levels'],
		['UserTicketsCapability']
	];
	public static function getSize() {
		return self::count();
	}
	
	public function getLabel(){
		return $this->ticket_levels->label;
	}
	
}
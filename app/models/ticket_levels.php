<?php
class TicketLevels extends ActiveRecord\Model {

	static $table_name = 'ticket_levels';
	static $has_many = [
		['user_tickets_capabilities'],
		['Ticket']
	];
	
	public function countUser(){
		return UserTicketsCapability::count(['ticket_levels_id' => $this->id]);
	}
}
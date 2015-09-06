<?php
class UserTicketsCapability extends ActiveRecord\Model {

	static $table_name = 'user_tickets_capabilities';
		static $belongs_to = [
			['user'],
			['TicketLevels'],
			['Ticket']
	];

	/**
	 * @param $user_id int
	 * @param $level_id int
	 * @param $is_set boolean
	 * 
	 * Set if an user can handle a ticket level
	 */
	 
	public static function setLevel($user_id, $level_id, $is_set){
		self::table()->delete([
			'ticket_levels_id' => [$level_id], 
			'user_id' => [$user_id]
			]);	
		if($is_set){
			self::create([
				'ticket_levels_id' => $level_id, 
				'user_id' => $user_id
				]);
		}
	}
		
}
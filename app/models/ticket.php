<?php
class Ticket extends ActiveRecord\Model {

	static $table_name = 'tickets';
	
	public static function getSize() {
		return self::count();
	}
}
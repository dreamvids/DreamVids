<?php

class Database {

	public static function connect() {
		ActiveRecord\Config::initialize(function($cfg) {
			
			$dbHost = Config::getValue_('dbHost');
			$dbUser = Config::getValue_('dbUser');
			$dbPass = Config::getValue_('dbPass');
			$dbName = Config::getValue_('dbName');

			$cfg->set_model_directory(MODEL);
			$cfg->set_connections(array(
				'development' => 'mysql://'.$dbUser.':'.$dbPass.'@'.$dbHost.'/'.$dbName));
		});
	}

}
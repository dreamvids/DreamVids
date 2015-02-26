<?php

use ActiveRecord\Connection;
use ActiveRecord\ConnectionManager;

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
			try {
				ConnectionManager::get_connection("development");
			} catch (Exception $e) {
				$response = Utils::getInternalServerErrorResponse(true);
				$response->send();
				die();
			}

		});
	}
	
	/**
	 * 
	 * @param string $connection
	 * @return PDO
	 */
	public static function getPDOObject($connection = "nope"){
		return $connection == "nope" ? ActiveRecord\ConnectionManager::get_connection()->connection : ActiveRecord\ConnectionManager::get_connection($connection);
	}

}
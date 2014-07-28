<?php

class Database {

	public static function connect() {
		ActiveRecord\Config::initialize(function($cfg) {
			$appConfig = new Config(CONFIG.'app.json');
			$appConfig->parseFile();
			$values = Utils::objectToArray($appConfig->getValues());

			$dbHost = $values['dbHost'];
			$dbUser = $values['dbUser'];
			$dbPass = $values['dbPass'];
			$dbName = $values['dbName'];

			$cfg->set_model_directory(MODEL);
			$cfg->set_connections(array(
				'development' => 'mysql://'.$dbUser.':'.$dbPass.'@'.$dbHost.'/'.$dbName));
		});
	}

}
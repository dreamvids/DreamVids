<?php

class BDD_PDO
{
	public static $HOST = '127.0.0.1';
	public static $USERNAME = 'root';
	public static $PASSWORD = '';
	public static $DB_NAME = 'dreamvids';

	private $connect;
	
	public function __construct()
	{
		$this->$connect = new PDO('mysql:host='.$HOST.';dbname='.$DB_NAME.'', $USERNAME, $PASSWORD);
	}
	public function _connect()
	{
		return $this->connect;
	}
}
?>
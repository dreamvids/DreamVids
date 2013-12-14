<?php
class BDD
{
	private $table;
	private $prefixe;
	
	public function __construct()
	{
		mysql_connect('localhost', 'root', '');
		mysql_select_db('dreamvids');
		$this->table = '';
		$this->prefixe = '';
	}
	
	private function add_prefixe($table)
	{
		$this->table = ($this->prefixe != '') ? $this->prefixe.'_'.$table : $table;
	}
	
	public function error()
	{
		return mysql_error();
	}
	
	public function query($query)
	{
		return mysql_query($query);
	}
	
	public function select($fields, $table, $enplus="")
	{
		$this->add_prefixe($table);
		return mysql_query("SELECT ".$fields." FROM ".$this->table." ".$enplus."");
	}
	
	public function count($alias, $table,  $enplus="")
	{
		$this->add_prefixe($table);
		return mysql_query("SELECT COUNT(*) AS ".$alias." FROM ".$this->table." ".$enplus."");
	}
	
	public function fetch_array($reponse)
	{
		return mysql_fetch_array($reponse);
	}
	
	public function num_rows($reponse)
	{
		return mysql_num_rows($reponse);
	}
	
	public function update($table, $fields, $condition="")
	{
		$this->add_prefixe($table);
		mysql_query("UPDATE ".$this->table." SET ".$fields." ".$condition."");
	}
	
	public function insert($table, $fields)
	{
		$this->add_prefixe($table);
		mysql_query("INSERT INTO ".$this->table." VALUES(".$fields.")");
	}
	
	public function delete($table, $condition="")
	{
		$this->add_prefixe($table);
		mysql_query("DELETE FROM ".$this->table." ".$condition."");
	}
	
	public function real_escape_string($string)
	{
		return mysql_real_escape_string($string);
	}
	
	public function show_columns($table)
	{
		$this->add_prefixe($table);
		return mysql_query("SHOW COLUMNS FROM ".$this->table."");
	}
	
	public function truncate($table)
	{
		$this->add_prefixe($table);
		mysql_query("TRUNCATE TABLE ".$this->table);
	}
	
	public function insert_id()
	{
		return mysql_insert_id();
	}
	
	public function close()
	{
		mysql_close();
	}
}
?>
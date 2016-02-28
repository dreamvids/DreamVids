<?php
abstract class Model {	
	static $table_name = '';
	
	public static function fetchAll() {
		$model = get_called_class();
		$req = DB::get()->query("SELECT id FROM ".static::$table_name);
		$tab = [];
		while ($rep = $req->fetch()) {
			$tab[] = new $model($rep['id']);
		}
		$req->closeCursor();
		
		return $tab;
	}

	public static function insertIntoDb(array $args): int {
		$q_args = array();
		foreach ($args as $a) {
			$q_args[] = '?';
		}
		$str = implode(', ', $q_args);
		$req = DB::get()->prepare("INSERT INTO ".static::$table_name." VALUES('', $str)");
		$req->execute($args);
		return DB::get()->lastInsertId();
	}

	public static function exists(string $col, $value): bool {
		$req = DB::get()->prepare("SELECT COUNT(*) AS nb FROM ".static::$table_name." WHERE ".$col." = ?");
		$req->execute([$value]);
		$data = $req->fetch();
		$req->closeCursor();
		return ($data['nb'] > 0);
	}

	protected function requestDb(int $id): array {
		$req = DB::get()->prepare("SELECT * FROM ".static::$table_name." WHERE id = ?");
		$req->execute(array($id));
		$data = $req->fetch();
		$req->closeCursor();
		return $data;
	}

	protected function saveToDb(int $id, array $cols, array $args) {
		$q_args = array();
		foreach ($cols as $c) {
			$q_args[] = $c.'=?';
		}
		$str = implode(', ', $q_args);
		array_push($args, $id);

		$req = DB::get()->prepare("UPDATE ".static::$table_name." SET $str WHERE id=?");
		$req->execute($args);
	}

	protected function removeFromDb(int $id) {
		$req = DB::get()->prepare("DELETE FROM ".static::$table_name." WHERE id = ?");
		$req->execute(array($id));
	}
}
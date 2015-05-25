<?php
class WordSearch extends ActiveRecord\Model {

	static $table_name = 'words_searches';
	public static function addWords($words){
		$user_id = Session::isActive() ? Session::get()->id : null;
		foreach($words as $k => $word){
			die($word . "\n");
			$test = self::find_by_sql("SELECT COUNT(*) AS count FROM words_searches WHERE user_id = ? AND word = ? AND timestamp>".(Utils::tps()-10), [$user_id, $word])[0];
			if($test->count == 0){
				
				self::create([
						"word" => $word,
						"user_id" => $user_id,
						"timestamp" => Utils::tps()
				]);
			}
		}
	}
	
	public static function getMatchingWords($word, $amount = 5){
		var_dump($word);
		$param = [$word];
		$result = [];
		if(Session::isActive()){
			$query = "SELECT * FROM words_searches WHERE word LIKE CONCAT(?, '%') AND user_id LIKE ? AND word IN(SELECT word FROM modo_words_searches WHERE validated=1) GROUP BY word ORDER BY COUNT(word) DESC LIMIT $amount";
			$param[] = Session::get()->id;
			$stmt = Database::getPDOObject()->prepare($query);
			$stmt->execute($param);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if(count($result) < $amount){
				$query = "SELECT * FROM words_searches WHERE word LIKE CONCAT(?, '%') AND word IN(SELECT word FROM modo_words_searches WHERE validated=1) AND word NOT IN (SELECT word FROM ($query) AS temp) GROUP BY word ORDER BY COUNT(word) DESC LIMIT ".($amount-count($result));
				$stmt = Database::getPDOObject()->prepare($query);
				$param = [$word, $word, Session::get()->id];
				$stmt->execute($param);
				
				while ($v = $stmt->fetch(PDO::FETCH_ASSOC)){
					$result[]=$v;
				}
				
			}
		}else{
			$query = "SELECT * FROM words_searches WHERE word LIKE CONCAT(?, '%') AND word IN(SELECT word FROM modo_words_searches WHERE validated=1) GROUP BY word ORDER BY COUNT(word) DESC LIMIT $amount";
			$stmt = Database::getPDOObject()->prepare($query);
			$stmt->execute($param);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		return array_map(function ($v){
			return $v['word'];
		}, $result);
	}
	
}
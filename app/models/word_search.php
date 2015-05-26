<?php
class WordSearch extends ActiveRecord\Model {

	static $table_name = 'words_searches';
	public static function addWords($words){
		$user_id = Session::isActive() ? Session::get()->id : null;
		$r = [];
		foreach($words as $k => $word){
			
			$test = self::find_by_sql("SELECT COUNT(*) AS count FROM words_searches WHERE  word IN(SELECT word FROM modo_words_searches WHERE validated=0 AND word = ?) OR ( user_id = ? AND word = ? AND timestamp>".(Utils::tps()-10) . ')', [$word, $user_id, $word])[0];
			if($test->count == 0){
				
				self::create([
						"word" => $word,
						"last_word" => isset($words[$k-1]) ? $words[$k-1] : null, 
						"user_id" => $user_id,
						"timestamp" => Utils::tps()
				]);
			}
			
			$r[$word] = $test->count;
		}
		return $r;
	}
	
	public static function getMatchingWords($word, $last_word, $amount_base = 5){
		
		$amount = $amount_base*2;
		 
		$last_word_sql = " last_word DESC, last_word = ? DESC, ";
		$last_word = $last_word != '' ? $last_word : null;
		$param = [$word];
		$result = [];
		if(Session::isActive()){
			$query = "SELECT * FROM words_searches WHERE word LIKE CONCAT(?, '%') AND user_id LIKE ? AND word IN(SELECT word FROM modo_words_searches WHERE validated=1) GROUP BY word, last_word ORDER BY $last_word_sql COUNT(word) DESC LIMIT $amount";
			$param[] = Session::get()->id;
			$param[] = $last_word;
			$stmt = Database::getPDOObject()->prepare($query);
			$stmt->execute($param);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if(count($result) < $amount){
				$query = "SELECT * FROM words_searches WHERE word LIKE CONCAT(?, '%') AND word IN(SELECT word FROM modo_words_searches WHERE validated=1) AND word NOT IN (SELECT word FROM ($query) AS temp) GROUP BY word, last_word ORDER BY $last_word_sql COUNT(word) DESC LIMIT ".($amount-count($result));
				$stmt = Database::getPDOObject()->prepare($query);
				$param = [$word, $word, Session::get()->id, $last_word, $last_word];
				$stmt->execute($param);
				
				while ($v = $stmt->fetch(PDO::FETCH_ASSOC)){
					$result[]=$v;
				}
				
			}
		}else{
			$param[] = $last_word;
			$query = "SELECT * FROM words_searches WHERE word LIKE CONCAT(?, '%') AND word IN(SELECT word FROM modo_words_searches WHERE validated=1) GROUP BY word, last_word ORDER BY $last_word_sql COUNT(word) DESC LIMIT $amount";
			$stmt = Database::getPDOObject()->prepare($query);
			$stmt->execute($param);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		$result = array_map(function ($v){
			return $v['word'];
		}, $result); 
		$result = array_unique($result);
		$result = array_slice($result, 0, $amount);
		
		return $result;
	}
	
}
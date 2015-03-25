<?php
class Eggs extends ActiveRecord\Model {

	static $table_name = 'event_eggs';
	
	public static function getDreamvidsEggs(){
		return self::find('all', ['conditions' => ['site' => 'dreamvids'], 'order' => '!found DESC, show_timestamp DESC']);
	}
	
	public static function getCaviconEggs($only_not_found = false){
		if(!$only_not_found){
			return self::find('all', ['conditions' => ['site' => 'cavicon'], 'order' => '!found DESC, show_timestamp DESC']);
		}else{
			return self::find('all', ['conditions' => ['site' => 'cavicon', 'found' => 0], 'order' => '!found DESC, show_timestamp DESC']);
		}
			
	}
	
	public static function generateId(){
		$id = sha1(uniqid() . md5(Utils::tps()));
		return self::exists(['id' => $id]) ? self::generateId() : $id;
	}
	
	public static function isAvailable($id){
		if(!self::exists(['id' => $id])){ return false; }
		$egg = self::find($id);
		return !($egg->found || $egg->show_timestamp > Utils::tps());
			
	}
	
	public static function countUserScore(User $user){
		return self::find_by_sql("SELECT SUM(`points`) as score FROM ".self::$table_name." WHERE user_id = ? AND found = 1", [$user->id])[0]->score;
	}
	
	/**
	 * 
	 * @param $timestamp int when do we show it 
	 * @param $emplacement string where do we show it (empty string id $site=cavicon)
	 * @param string $site default : dreamvids. Can also be cavicon
	 * @param int $pts Number of points to win (1 or 3) (default : 1). If 3 : the egg is a gold one.
	 * @return Eggs
	 */
	public static function createNewEgg($timestamp, $emplacement, $site = 'dreamvids', $pts = 1){
		
		$egg = self::create([
				'id' => self::generateId(),
				'site' => $site,
				'show_timestamp' => $timestamp,
				'emplacement' => $emplacement,
				'points' => $pts
		]);
		
		return $egg;
		
	}
	
	public static function getEggsFromUri($uri) {
		return self::find('all', ['conditions' => ['site = "dreamvids" AND emplacement = ? AND found = 0 AND show_timestamp < '.Utils::tps(), $uri]]);
	}
	
	public static function getBestUsers($limit=10){
		
		return User::find_by_sql("
SELECT * FROM users 
INNER JOIN
(SELECT user_id, SUM(`points`) as score FROM event_eggs WHERE found = 1 GROUP BY user_id) as score
ON `users`.id = `score`.user_id ORDER BY score DESC LIMIT $limit;");
	}
	
	public function getType(){
		return $this->points == 3 ? 'gold' : 'normal';
	}
	
}
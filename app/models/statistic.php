<?php
class Statistic {
	
	/** 
	 * @param string $query
	 * <ul>
	 * <li>Default : count the user that have 1 channel</li>
	 * <li>Examples :  countUserHavingChannels("> 2");</li>
	 * <li>countUserHavingChannels("< 3");</li>
	 * <li>countUserHavingChannels("= 3");</li>
	 * </ul>
	 */
	
	public static function countUserHavingChannels($query = "= 1") {
		$request = "SELECT COUNT(*) as count FROM `users` WHERE id IN ( SELECT owner_id FROM users_channels WHERE owner_id = `users`.id HAVING COUNT(*) $query )";
		$pdo = Database::getPDOObject();
		$result = $pdo->query($request)->fetch(PDO::FETCH_NAMED)['count'];
		
		return $result;
	}
	
	public static function countVideosHavingComments() {
		$request = "SELECT COUNT(*) AS count FROM (SELECT DISTINCT video_id FROM videos_comments) AS temp";
		
		$pdo = Database::getPDOObject();
		$result = $pdo->query($request)->fetch(PDO::FETCH_NAMED)['count'];
	
		return $result;
	}
	
	/**
	 * 
	 * @param string $class_name
	 * @param string $timestamp_field
	 * @param number $long_ago
	 * @param number $step
	 * @param string $date_format
	 * @return array
	 */
	public static function getDataForGraph($class_name, $timestamp_field = 'timestamp', $long_ago = 2592000, $step = 86400, $date_format = "Y-m-d") {
		$table_name = $class_name::$table_name == '' ? strtolower($class_name) . 's' : $class_name::$table_name;
		$min_timestamp = (Utils::tps() -  $long_ago);
		$request = "SELECT DISTINCT time, count(*) AS count FROM (
SELECT *, ((ROUND(`$timestamp_field` / ($step))-1)*($step)) as time FROM `$table_name`
HAVING `$timestamp_field` > $min_timestamp
ORDER BY $timestamp_field  DESC) AS temp
GROUP BY time";
		$temp = $class_name::find_by_sql($request);
		$result = [];
		
		foreach ($temp as $k => $value) {
			$result[date($date_format, $value->time)] = [date($date_format, $value->time) , $value->count];
		}
		foreach (range($min_timestamp, Utils::tps(), $step) as $index => $v){
			$temp_date = date($date_format, $v);
			if(!isset($result[$temp_date])){
				$result[$temp_date] = [$temp_date, 0];
			}
		}
		return $result;
	}
}
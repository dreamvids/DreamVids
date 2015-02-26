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
}
<?php

class Utils {
	
	public static function parseURL($input) {
		if(self::stringStartsWith($input, '/')) {
			$input = substr_replace($input, '', 0, 1);
		}

		if(self::stringEndsWith($input, '/')) {
			$input = substr_replace($input, '', strlen($input) - 1, 1);
		}
		
		return explode("/", $input);
	}

	public static function stringStartsWith($haystack, $needle) {
		return !strncmp($haystack, $needle, strlen($needle));
	}

	public static function stringEndsWith($haystack, $needle) {
		$length = strlen($needle);

		if ($length == 0) {
			return true;
		}

		return substr($haystack, -$length) === $needle ? true : false;
	}

	public static function tps() {
		$decalage = 0;
		return time() + $decalage*3600;
	}

	public static function secure($str) {
		return htmlspecialchars(strip_tags(stripslashes($str)), ENT_QUOTES, 'UTF-8');
	}

	public static function relative_time($iTime) {
		$iTimeDifference = time() - $iTime;

		if( $iTimeDifference<0 ) { return; }

		$iSeconds = $iTimeDifference ;
		$iMinutes = round( $iTimeDifference/60 );
		$iHours = round( $iTimeDifference/3600 );
		$iDays = round( $iTimeDifference/86400 );
		$iWeeks = round( $iTimeDifference/604800 );
		$iMonths = round( $iTimeDifference/2419200 );
		$iYears = round( $iTimeDifference/29030400 );
		$return = 'Il y a';

		if( $iSeconds<60 ){
		$return .= " ".'moins d\' une minute';}
		elseif( $iMinutes<60 ){
		$return .= " ".$iMinutes . ' minute' . ( $iMinutes>1 ? 's' : '' );}
		elseif( $iHours<24 ){
		$return .= " ".$iHours . ' heure' . ( $iHours>1 ? 's' : '' );}
		elseif( $iDays<7 ){
		$return .= " ".$iDays . ' jour' . ( $iDays>1 ? 's' : '' );}
		elseif( $iWeeks <4 ){
		$return .= " ".$iWeeks . ' semaine' . ( $iWeeks>1 ? 's' : '' );}
		elseif( $iMonths<12 ){
		$return .= " ".$iMonths . ' mois';}
		else{
		$return .= " ".$iYears . ' an' . ( $iYears>1 ? 's' : '' );}
		return $return;
	}
}

<?php

require_once MODEL.'session.php';

/**
 * Traductor class
 *
 */
class Traductor{

	private static $fr_array = array();
	private static $en_array = array();
	private static $languages = array();
	private static $prefered_language = 'fr';

	public static function init() {
		self::$languages = array(
				"fr" => self::$fr_array,
				"en" => self::$en_array
		);
		if(Session::isActive()){
			self::$prefered_language = Session::get()->getLanguageSetting();
		}else{
			self::$prefered_language = self::GetLanguageFromHttpRequest();
		}

	}

	/**
	 * 
	 * @return string The language letters
	 */
	private static function GetLanguageFromHttpRequest() {
		if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
			$string_accept = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		}else{
			return 'fr';
		}
		$string_accept_array = preg_split( "#(,|;)#", $string_accept);

		foreach ($string_accept_array as $accept) {
			$accept = strtolower($accept);
			if(Utils::stringStartsWith($accept, "q=")){
				continue;
			}else{
				$accept = explode("-", $accept)[0];

				if(in_array($accept, array_keys(self::$languages))){
					return $accept;
				}
			}
		}
		
		return "fr";

	}

}
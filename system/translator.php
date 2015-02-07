<?php

require_once MODEL.'session.php';

/**
 * Translator class
 * To use it :
 * <ol>
 * <li>Add the json with translation you want in app/config/translations/:lang_translations.json.</li>
 * <li>Then register the array you want by adding it in init() function</li>
 * <li>You can now access the value by Translator::get("the.subcategory.name") or by get / index in /translator[:name]</li>
 * </ol>
 */
class Translator{
	
	private static $languages = array();
	private static $prefered_language = 'fr';
	
	/**
	 * @var Request
	 */
	private static $request;
	
	public static function init($request) {
		
		self::$request = $request;
		
		self::registerLanguage(array("fr"));


		if(Session::isActive()){
			self::$prefered_language = Session::get()->getLanguageSetting() == "auto" ? self::GetLanguageFromHttpRequest() : Session::get()->getLanguageSetting();
		}else{
			self::$prefered_language = self::GetLanguageFromHttpRequest();
		}

	}
	/**
	 *
	 * @param The $name of the string "menu.home"
	 * @param $language Optional if you want to override
	 */
	public static function get($name = "all", $language = false) {
		$array_navigator = self::getLanguageArray($language);
		if($name == "all"){
			return $array_navigator;
		}
		$array_requested_key = explode(".", $name);
		foreach ($array_requested_key as $key) {
			if(isset($array_navigator[$key])){
			$array_navigator = $array_navigator[$key];				
			}else{
				return $name;
			}
		}

		return $array_navigator;
	}

	/**
	 *
	 * @return string The language letters
	 */
	private static function GetLanguageFromHttpRequest() {
		if(self::$request->getAcceptedLanguages()){
			$string_accept = self::$request->getAcceptedLanguages();
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

	private static function getLanguageArray($language = false){
		if(!$language){
			return self::$languages[self::$prefered_language];
		}else{
			return isset(self::$languages[$language]) ? self::$languages[$language] : self::$languages["fr"];
		}
	}
	private static function registerLanguage($languages) {

		foreach ($languages as $language) {

			$filename = TRANSLATIONS.$language."_translations.json";
			if(file_exists($filename)){
				$lang_array = json_decode(file_get_contents($filename), true);
				
				self::$languages = array_merge(self::$languages, array($language => $lang_array));
			}
		}
				
		
	}
	
	public static function getLanguagesList() {
		$result = array();
		foreach (self::$languages as $value => $array) {
			$result[$value] = self::get("name", $value);
		}
		return $result;
	}
	
	public static function getCurrentLanguageName() {
		return self::$prefered_language;
	}
	
	public static function translateStringifiedDate($date, $lang = 'none') {

			if($lang == 'none'){
				$lang = self::getCurrentLanguageName();
			}else{
				if(isset(self::$languages[$lang])){
					$lang = self::$languages[$lang];
				}else{
					$lang = self::getCurrentLanguageName();
				}
			}
			
			$array_translate = [];
			$array_translate['en'] = array("January","February","March","April","May","June","July","August","September","October","November","December");
			$array_translate['fr'] = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Decembre");
			
			return str_replace($array_translate['en'], $array_translate[$lang], $date);
	}

}
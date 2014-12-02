<?php

require_once MODEL.'session.php';

/**
 * Translator class
 *
 */
class Translator{

	private static $fr_array = array(
			"header" => array(
					"menu" => array(
							"home" => "Accueil",
							"news" => "Nouveautées",
							"flux" => "Flux d'activité",
							"upload" => "Uploader",
							"live" => "Diffuser",
							"videos" => "Mes vidéos",
							"user_submenu" => array(
									"account" => "Mon compte",
									"channels" => "Mes chaînes",
									"playlists" => "Mes playlists",
									"messages" => "Mes messages",
									"logout" => "Déconnexion",
									"login" => "Connexion",
									"register" => "Inscription"

							)
					),
					"search" => "Rechercher"
			),
			"common" => array(
					"subscriber" => "Abonné",
					"subscriptions" => "Abonnements",
					"time" => array(
							"minute" => "minute",
							"hour" => "heure",
							"day" => "jour",
							"month" => "mois",
							"week" => "semaine",
							"year" => "an"
					)
			),			
			"footer" => array(
					"about" => "Qui sommes nous ?",
					"contributors" => "Contributeurs",
					"tos" => "CGU",
					"shop" => "Boutique",
					"dev_blog" => "Blog de développement",
					"partners" => "Partenaires",
					"become_partner" => array(
							"title" => "Vous ici ?",
							"popup" => "Envoyez un E-Mail à \'partenaires [arobase] dreamvids.fr\'"
					),
					"social" => "Social"
			)

	);
	private static $en_array = array(
			"header" => array(
					"menu" => array(
							"home" => "Home",
							"news" => "News",
							"flux" => "Notifications",
							"upload" => "Upload",
							"live" => "Broadcast",
							"videos" => "My Videos",
							"user_submenu" => array(
									"account" => "My account",
									"channels" => "My channels",
									"playlists" => "My playlists",
									"messages" => "My messages",
									"logout" => "Log Out",
									"login" => "Log In",
									"register" => "Register"

							)
					),
					"search" => "Search"
			),
			"common" => array(
					"subscriber" => "Subscriber",
					"subscriptions" => "Subscriptions",
					"time" => array(
							"minute" => "minute",
							"hour" => "hour",
							"day" => "day",
							"month" => "month",
							"week" => "week",
							"year" => "year"
					)
			),
			"footer" => array(
					"about" => "About us",
					"contributors" => "Contributors",
					"tos" => "TOS",
					"shop" => "Shop",
					"dev_blog" => "Development blog",
					"partners" => "Parterns",
					"become_partner" => array(
							"title" => "Want to become a partner ?",
							"popup" => "Send a Mail at \'partenaires [at] dreamvids.fr\'"
					),
					"social" => "Social"
			)
	);
	private static $languages = array();
	private static $prefered_language = 'fr';

	public static function init() {
		self::$languages = array(
				"fr" => self::$fr_array,
				"en" => self::$en_array
		);
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
	public static function get($name, $language = false) {
		$array_navigator = self::getLanguageArray($language);
		$array_requested_key = explode(".", $name);
		foreach ($array_requested_key as $key) {

			$array_navigator = $array_navigator[$key];
		}

		return $array_navigator;
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

	private static function getLanguageArray($language = false){
		if(!$language){
			return self::$languages[self::$prefered_language];
		}else{
			return isset(self::$languages[self::$prefered_language]) ? self::$languages[self::$prefered_language] : self::$languages["fr"];
		}
	}

}
<?php

require_once SYSTEM.'request.php';
require_once SYSTEM.'view_response.php';

require_once MODEL.'storage_server.php';
require_once MODEL.'backup.php';
require_once MODEL.'video.php';

class Utils {

	public static function getPerformedRequest() {
		$requestProtocol = $_SERVER['SERVER_PROTOCOL'];
		$requestMethod = $_SERVER['REQUEST_METHOD'];
		$requestURI = self::getCurrentURI();
		$requestAcceptedData = $_SERVER['HTTP_ACCEPT'];
		
		if(strtoupper($requestMethod) == 'POST') {
			if(isset($_POST['_method'])) {
				switch(strtoupper($_POST['_method'])) {
					case Method::PUT:
						$requestMethod = Method::PUT;
						break;

					case Method::DELETE:
						$requestMethod = Method::DELETE;
						break;
					
					default:
						break;
				}
			}
		}

		return new Request($requestProtocol, $requestMethod, $requestURI, $requestAcceptedData);
	}
	
	public static function getCurrentURI() {
		$requestURI = isset($_GET['uri']) ? $_GET['uri'] : '/';
		if(strpos($requestURI, '_json'))
			$requestURI = str_replace('_json', '.json', $requestURI);
		$requestURI = trim($requestURI, '/');
		return $requestURI;
	}

	public static function tps() {
		$decalage = 0;
		return time() + $decalage*3600;
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

	public static function secureArray($array) {
		$secureArray = array();

		foreach ($array as $key => $value) {
			if(is_string($value)) {
				$secureArray[$key] = Utils::secure($value);
			}
		}

		return $secureArray;
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

	public static function objectToArray($data) {
		if(is_object($data))
			$data = get_object_vars($data);

		if(is_array($data))
			return $data;
		else
			return false;
	}

	public static function debug($data, $exit = false) {
		if($data) {
			print '<pre>';
			print_r($data);
			print '</pre>';
		}
		if($exit)
			exit();
	}

	public static function getNotFoundResponse() {
		return new ViewResponse('error/404', array(), true, 'layouts/main.php', 404);
	}

	public static function getForbiddenResponse() {
		return new ViewResponse('error/403', array(), true, 'layouts/main.php', 403);
	}

	public static function getUnauthorizedResponse() {
		return new ViewResponse('error/401', array(), true, 'layouts/main.php', 401);
	}

	public static function getInternalServerErrorResponse() {
		return new ViewResponse('error/500', array(), true, 'layouts/main.php', 500);
	}

	public static function sendResponse($response) {
		if($response instanceof Response) {
			$response->send();
		}
		else {
			self::getInternalServerErrorResponse()->send();
		}
	}

	public static function validateUsername($string='') {
		if($string != '') {
			if(preg_match("#^[a-zA-Z0-9-_\.]{3,40}$#",$string)) return true;
		}

		return false;
	}

	public static function validateMail($string='') {
		if($string != '') {
			if(filter_var($string, FILTER_VALIDATE_EMAIL)) return true;
		}

		return false;
	}

	public static function validateVideoInfo($title, $description, $tags) {
		if(!empty($title) && !empty($description) && !empty($tags)) {
			return true;
		}

		return false;
	}

	public static function isUrlValid($url) {
		$fileHeaders = @get_headers($url);
		return strpos($fileHeaders[0], '200 OK') !== false;
	}

	public static function getVideoCardHTML($vid) {
		return '<div class="card video">
				<div class="thumbnail bg-loader" data-background-load-in-view data-background="'.$vid->getThumbnail().'">
					<div class="time">'.self::sec2ms($vid->duration).'</div>
					<a href="'.WEBROOT.'watch/'.$vid->id.'" class="overlay"></a>
				</div>
				<div class="description">
					<a href="'.WEBROOT.'watch/'.$vid->id.'"><h4>'.$vid->title.'</h4></a>
					<div>
						<span class="view">'.number_format($vid->views).'</span>
						<a class="channel" href="'.WEBROOT.'channel/'.$vid->poster_id.'">'.UserChannel::getNameById($vid->poster_id).'</a>
					</div>
				</div>
			</div>';
	}

	public static function whoIsTheBestDev() {
		$foo = array('1.1862222222222', '1.9886666666667', '1.7618888888889', '1.6921111111111', '1.9014444444444', '1.4653333333333', '1.7618888888889', '1.6921111111111', '1.9014444444444');
		$bar = '';

		for($i = 0; $i < count($foo); $i++) {
			$zbrah = 0;
			$lampe = 18;

			for($j=0; $j < 6; $j++) {
				$webcam = gmp_strval(gmp_nextprime($lampe));
				$lampe+=4;
				$zbrah += $webcam;
			}

			$boubouleCircumLol = 40075;
			$boubouleDiameter = 6371 * pow(sqrt(2), 2);
			$cuisine = $boubouleCircumLol / $boubouleDiameter;
			$tourEiffel = $foo[$i];
			$cookie = round($tourEiffel * $zbrah / $cuisine);

			$bar .= chr($cookie);
		}

		return $bar;
	}

	public static function secure($str) {
		$secured = $str;
		$secured = htmlentities(stripslashes($secured), ENT_QUOTES, 'UTF-8');
		$secured = str_replace('<', '&lt;', $secured);
		$secured = str_replace('>', '&gt;', $secured);
		return (is_string($str) && json_decode($str) == null) ? $secured : $str;
	}
	
	public static function securingData($data) {
		foreach ($data as $key => $value) {
			if (!is_string($value) && is_subclass_of($value, "ActiveRecord\Model")) {
				$data[$key] = self::secureActiveRecordModel($value);
			}
			else if (is_array($value)) {
				$data[$key] = self::securingData($value);
			}
			else {
				$data[$key] = self::secure($value);
			}
		}
		return $data;
	}
	
	public static function secureActiveRecordModel($obj) {
		foreach ($obj->attributes() as $key => $value) {
			$obj->$key = self::secure($value);
		}
		return $obj;
	}
	
	public static function upload($file, $type, $fileId, $channelId, $default = '', $backup = false) {
		if (!file_exists(ROOT.'uploads/')) {
			mkdir(ROOT.'uploads');
		}
		if (!file_exists(ROOT.'uploads/'.$channelId.'/')) {
			mkdir(ROOT.'uploads/'.$channelId);
		}
		
		if ($file['name'] != '') {
			$name = $file['name'];
			$ext = explode('.', $name);
			$ext = $ext[count($ext)-1];
			switch ($type) {
				case 'vid':
					if (in_array(strtolower($ext), array('webm', 'mp4', 'm4a', 'mpg', 'mpeg', '3gp', '3g2', 'asf', 'wma', 'mov', 'avi', 'wmv', 'ogg', 'ogv', 'flv', 'mkv'))) {
						$path = 'uploads/'.$channelId.'/'.$fileId.'.'.$ext;
						move_uploaded_file($file['tmp_name'], ROOT.$path);
						$duration = self::getVideoDuration(ROOT.$path);
						StorageServer::lockFreestServer();
						self::convert(ROOT.$path);
						$serv = StorageServer::getFreestServer();
						return array($serv->address.$path, $duration);
					}
				break;
				
				case 'img':
					if (in_array($ext, array('jpeg', 'jpg', 'png', 'gif', 'tiff', 'svg'))) {
						$path = 'uploads/'.$channelId.'/'.$fileId.'.'.$ext;
						
						move_uploaded_file($file['tmp_name'], ROOT.$path);
						if ($backup) {
							StorageServer::backup($fileId.'.'.$ext, $channelId);
						}
						return WEBROOT.$path;
					}
				break;
			}
		}
		return $default;
	}
	
	public static function convert($path) {
		system('convert.sh '.escapeshellarg($path).' '.ROOT.'');
	}
	
	public static function getVideoDuration($videofile) {
		ob_start();
		passthru("ffmpeg -i $videofile 2>&1");
		$duration = ob_get_contents();
		ob_clean();
		 
		$search='/Duration: (.*?),/';
		$duration=preg_match($search, $duration, $matches, PREG_OFFSET_CAPTURE, 3);
		 
		return self::hms2sec($matches[1][0]);
	}
	
	public static function hms2sec($hms) {
        list($h, $m, $s) = explode(":", $hms);
        $seconds = 0;
        $seconds += (intval($h) * 3600);
        $seconds += (intval($m) * 60);
        $seconds += (intval($s));
        return $seconds;
	}
	
	public static function sec2ms($sec) {
		$m = floor($sec / 60);
		$s = $sec % 60;
		$s = (strlen($s) > 1) ? $s : '0'.$s;
		return $m.':'.$s;
	}
}
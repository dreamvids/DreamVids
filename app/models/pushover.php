<?php

require_once SYSTEM.'push_notification.php';
//TODO migrate this file to work along with the PushNotification class
class PushoverNotification /* extends PushNotification */{
	private static $token = 'your-pushover-application-token';
	private static $url = 'https://api.pushover.net/1/messages.json';
	private $array;

	public function __construct() {
		$this->array = ['token' => self::$token];
	}

	public function setMessage($msg) {
		$this->array['message'] = $msg;
	}

	public function setReceiver($receiver) {
		$this->array['user'] = Config::getValue_("po_".$receiver);
	}

	public function setExtraParameter($name, $value) {
		$this->array[$name] = $value;
	}

	public function send() {
		$postdata = http_build_query($this->array);

		$opts = array('http' =>
		    array(
		        'method'  => 'POST',
		        'header'  => 'Content-type: application/x-www-form-urlencoded',
		        'content' => $postdata
		    )
		);

		$context  = stream_context_create($opts);

		$result = file_get_contents(self::$url, false, $context);
	}
}
<?php

require_once SYSTEM.'push_notification.php';

class PushBulletNotification  extends PushNotification {

	public function __construct($title = '', $message = '', $destinations = []) {
		parent::__construct($title, $message, $destinations, 'MYqzgpSsoSSuyUXuqhdccKTQwAucFTvV');
		$this->url = "https://api.pushbullet.com/v2/pushes";
	}

	public function send() {
		$result = [];
		foreach($this->destinations as $email){
			$postdata = [
				'type' => 'note',
				'title' => $this->title,
				'body' => $this->message,
				'email' => $email
				];
	
			$opts = array('http' =>
			    array(
			        'method'  => 'POST',
			        'header'  => 
			        			"Content-type: application/json\r\n".
			        			"Access-Token: $this->token\r\n",
			        'content' => json_encode($postdata, JSON_FORCE_OBJECT)
			    )
			);
	
			$context  = stream_context_create($opts);
			$result[] = file_get_contents($this->url, false, $context);
		}
		
		return $result;
	}
}
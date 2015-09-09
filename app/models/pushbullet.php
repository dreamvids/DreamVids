<?php

require_once SYSTEM.'push_notification.php';

class PushBulletNotification  extends PushNotification {
	
	protected $is_link_push = false;
	protected $link_url = '';
	
	public function __construct($title = '', $message = '', $destinations = [], $is_link = false, $link_url = '') {
		parent::__construct($title, $message, $destinations, include CONFIG . 'pushbullet_key.php');
		$this->is_link_push = $is_link;
		$this->link_url = $link_url;
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
			if($this->is_link_push && $this->link_url != ''){
				$postdata['type'] = 'link';
				$postdata['url'] = $this->link_url;
			}
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
			$result[] = @file_get_contents($this->url, false, $context);
		}
		//file_put_contents(CACHE.'pushbullet_limit.txt', json_encode($http_response_header, JSON_FORCE_OBJECT | JSON_PRETTY_PRINT));
		return $result;
	}
}
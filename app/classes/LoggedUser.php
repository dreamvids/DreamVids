<?php

require_once APP.'classes/User.php';

class LoggedUser extends User {

	private $ip;
	private $sessionId;

	public function LoggedUser($userId, $sessionId) {
		parent::__construct();
		parent::find_by_id($userId);
		$this->sessid = $sessid;
        $this->ip = $_SERVER['REMOTE_ADDR'];
	}

	public function getSessionId() {
    	return $this->sessid;
    }
    
    public function getIpAddress() {
        return $this->ip;
    }

}
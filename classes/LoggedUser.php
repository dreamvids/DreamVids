<?php

require_once('User.php');

class LoggedUser extends User {
	private $sessid;
    private $ip;
    
    public function __construct($user_id, $sessid) {
        parent::__construct($user_id);
        $this->sessid = $sessid;
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->updateDatabaseInfos();
    }
    
    private function updateDatabaseInfos() {
    	$db = new BDD();
    	$expire = tps() + 15*60;
		$db->update("users_sessions", "expiration='".$expire."'", "WHERE user_id='".$this->getId()."' AND remember='0'");
		$db->update("users", "actual_ip='".$_SERVER['REMOTE_ADDR']."'", "WHERE id='".$this->getId()."'");
		$db->close();
    }
    
    public function getSessionId() {
    	return $this->sessid;
    }
    
    public function getIpAddress() {
        return $this->ip;
    }
}

?>
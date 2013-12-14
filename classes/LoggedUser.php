<?php

require_once('User.php');

class LoggedUser extends User {
    
    private $ip;
    
    public function __construct($name, $ip) {
        parent::__construct($name);
        $this->ip = $ip;
    }
    
    public function getIpAddress() {
        return $this->ip;
    }
}

?>
<?php

abstract class PushNotification {
    protected $title;
    protected $message;
    protected $destinations = [];
    protected $token;
    protected $url;
    
    public function __construct($title, $message, $destinations, $token){
        $this->title = $title;
        $this->message = $message;
        $this->destinations = $destinations;
        $this->token = $token;
    }
    
    public abstract function send();
    
}
<?php

class User {
    
    private $id;
    private $name;
    private $mail;
    private $avatar;
    private $subscribers;
    private $rank;

    public function __construct() {
        loadDataFromDatabase();
    }

    public function loadDataFromDatabase() {
    	//TODO: Load fields values from DB
    }

    public function saveDataToDatabase() {
    	//TODO: Save fields value to DB
    }

    public function setEmailAddress($newMail) {
        $this->mail = $newMail;
        saveDataToDatabase();
    }

    public function setAvatarPath($newAvatar) {
        $this->avatar = $newAvatar;
        saveDataToDatabase();
    }

    public function setSubscribers($newSubscribers) {
        $this->subscribers = $newSubscribers;
        saveDataToDatabase();
    }

    public function setRank($newRank) {
        $this->rank = $newRank;
        saveDataToDatabase();
    }

    //
    
	public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmailAddress() {
        return $this->mail;
    }

    public function getAvatarPath() {
        return $this->avatar;
    }

    public function getSubscribers() {
        return $this->subscribers;
    }

    public function getRank() {
        return $this->rank;
    }
}

?>
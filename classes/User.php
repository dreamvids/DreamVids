<?php

require_once('includes/bdd.class.php');

class User {

    private $existing;
    private $id = 0;
    private $name;
    private $mail;
    private $avatar;
    private $subscribers;
    private $rank;

    public function __construct($name) {
    	$this->name = $name;
        $this->loadDataFromDatabase();
    }

    // Read infos about User from the DB
    public function loadDataFromDatabase() {
    	$db = new BDD();
        $result = $db->query("SELECT * FROM users WHERE username='".$this->name."'") or die(mysql_error());

        while($row = mysql_fetch_array($result)) {
            $this->id = $row['id'];
            $this->mail = $row['email'];
            $this->avatar = $row['avatar'];
            $this->subscribers = $row['subscribers'];
            $this->rank = $row['rank'];
        }

        if($this->id != 0) {
            $this->existing = true;
        }
        else
            $this->existing = false;
    }

    public function saveDataToDatabase() {
        if($this->existing) {
            $db = new BDD();
            $db->query("UPDATE users SET username='$this->name', email='$this->mail', avatar='$this->avatar', subscribers='$this->subscribers', rank='$this->rank' WHERE id='$this->id'")
                or die(mysql_error());
        }
    }

    public function setEmailAddress($newMail) {
        if($this->existing) {
            $this->mail = $newMail;
            $this->saveDataToDatabase();
        }
    }

    public function setAvatarPath($newAvatar) {
        if($this->existing) {
            $this->avatar = $newAvatar;
            $this->saveDataToDatabase();
        }
    }

    public function setSubscribers($newSubscribers) {
        if($this->existing) {
            $this->subscribers = $newSubscribers;
            $this->saveDataToDatabase();
        }
    }

    public function setRank($newRank) {
        if($this->existing) {
            $this->rank = $newRank;
            $this->saveDataToDatabase();
        }
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
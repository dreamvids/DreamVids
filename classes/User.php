<?php
class User {

    private $existing;
    private $id = -1;
    private $name;
    private $mail;
    private $avatar = '';
    private $background;
    private $subscribers;
    private $subscriptions;
    private $reg_timestamp;
    private $rank; // 0: normal user, 1: moderator, 2: admin;

    public function __construct($id) {
        $this->loadDataFromDatabase($id);
    }

    // Read infos about User from the DB
    private function loadDataFromDatabase($id) {
    	$db = new BDD();
        $result = $db->select("*", "users", "WHERE id='".$db->real_escape_string($id)."'") or die(mysql_error());

        while($row = $db->fetch_array($result)) {
            $this->id = $row['id'];
            $this->name = $row['username'];
            $this->mail = $row['email'];
            $this->avatar = $row['avatar'];
            $this->background = $row['background'];
            $this->subscribers = $row['subscribers'];
            $this->subscriptions = explode(';', $row['subscriptions']);
            $this->reg_timestamp = $row['reg_timestamp'];
            $this->rank = $row['rank'];
        }

        if($this->id >= 0) {
            $this->existing = true;
        }
        else
            $this->existing = false;
    }

    public function saveDataToDatabase() {
        if($this->existing) {
            $db = new BDD();
            $subscriptions = $db->real_escape_string(implode(';', $this->subscriptions) );
            $db->update("users", "username='".$db->real_escape_string($this->name)."', email='".$db->real_escape_string($this->mail)."', avatar='".$db->real_escape_string($this->avatar)."', background='".$db->real_escape_string($this->background)."', subscribers='$this->subscribers', subscriptions='".$subscriptions."', rank='$this->rank'", "WHERE id='".$db->real_escape_string($this->id)."'");
        }
    }
    
    public function setUsername($newName) {
    	if ($this->existing) {
    		$this->name = $newName;
    	}
    }

    public function getUsername() {
        return $this->getName();
    }
    
    public function setPass($newPass) {
    	if ($this->existing) {
    		$db = new BDD();
    		$db->update("users", "pass='".sha1($db->real_escape_string($newPass) )."'",  "WHERE id='".$db->real_escape_string($this->id)."'");
    	}
    }

    public function setEmailAddress($newMail) {
        if($this->existing) {
            $this->mail = $newMail;
        }
    }

    public function setAvatarPath($newAvatar) {
        if($this->existing) {
            $this->avatar = $newAvatar;
        }
    }

    public function setBackgroundPath($newBackground) {
        if($this->existing) {
            $this->background = $newBackground;
        }
    }

    public function setSubscribers($bool=true) {
        if($this->existing) {
        	if ($bool)
	            $this->subscribers++;
	        else
	        	$this->subscribers--;
        }
    }
    
    public function setSubscriptions($ch_id, $bool=true) {
    	if ($this->existing) {
    		if ($bool)
    			$this->subscriptions[] = $ch_id;
    		else
    		{
    			$key = array_search($ch_id, $this->subscriptions);
    			unset($this->subscriptions[$key]);
    		}
    	}
    }

    public function setRank($newRank) {
        if($this->existing) {
            $this->rank = $newRank;
        }
    }

    //
    
	public function getId() {
        return $this->id;
    }

    public function getName($suffixe=false) {
    	switch ($this->getRank() )
    	{
    		case $GLOBALS['config']['rank_modo']:
    			$class = 'warning';
    			$value = 'Modo';
    		break;
    		
    		case $GLOBALS['config']['rank_adm']:
    			$class = 'danger';
    			$value = 'Admin';
    		break;
    		
    		default:
    			$class = '';
    			$value = '';
    		break;
    	}
    	$suf = ($class != '' && $value != '') ? ' <span class="label label-'.$class.'">'.$value.'</span>' : '';
        return ($suffixe) ? $this->name.$suf : $this->name;
    }

    public function getEmailAddress() {
        return $this->mail;
    }

    public function getAvatarPath() {
        return $this->avatar;
    }

    public function getBackgroundPath() {
        return $this->background;
    }

    public function getSubscribers() {
        return $this->subscribers;
    }
    
    public function getSubscriptions() {
    	return $this->subscriptions;
    }

    public function getRank() {
        return $this->rank;
    }

    public function getVids() {
        $db = new BDD();
        $req = $db->select("id", "videos", "WHERE user_id = '".$db->real_escape_string($this->id)."'");
        $vids = array();
        while ($data = $db->fetch_array($req) )
        {
        	$vids[] = Video::get($data['id']);
        }
        $db->close();
        return $vids;
    }

    // static methods
    public static function getNameById($userId) {
        $username = 'unknow';
        $db = new BDD();
        $result = $db->select("*", "users", "WHERE id='".$db->real_escape_string($userId)."'") or die(mysql_error());

        while($row = $db->fetch_array($result)) {
            $username = $row['username'];
        }

        return $username;
    }

    public static function getIdByName($username) {
        $id = -1;
        $db = new BDD();
        $result = $db->select("*", "users", "WHERE username='".$db->real_escape_string($username)."'") or die(mysql_error());

        while($row = $db->fetch_array($result)) {
            $id = $row['id'];
        }

        return $id;
    }

    public static function getRankNameByRankId($rankId) {
        switch ($rankId) {
            case $GLOBALS['config']['rank_mbr']:
                return 'DreamVids user';
                break;

            case $GLOBALS['config']['rank_modo']:
                return 'Moderator';
                break;

            case $GLOBALS['config']['rank_adm']:
                return 'Admin';
                break;
            
            default:
                return 'OVNI';
                break;
        }
    }
}

?>
<?php
class News extends ActiveRecord\Model {

	static $table_name = 'news';
	static $belongs_to = [
			['user']
		];

	public function getBadge(){
		if($this->icon != '' && $this->icon != null){
			return 	'<div class="timeline-badge '. (in_array($this->level, ['primary', 'info', 'success', 'warning', 'danger']) ? $this->level : '') .'"><i class="fa fa-'.$this->icon.'"></i></div>';
		}else{
			return '';
		}
	}
		
	public static function getLastNews($amount = 10){
		return self::find('all', ['limit' => $amount, 'order' => 'timestamp DESC']);
	}

	public function belongsToUser($user){
		return $this->user_id == $user->id;
	}

}
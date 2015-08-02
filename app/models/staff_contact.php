<?php
class StaffContact extends ActiveRecord\Model {

	static $table_name = 'staff_contact_details';

    public static function getImageName($user){
        if(isset($user->details->team_img_name)){
            return IMG . 'team/' . $user->details->team_img_name;
        }else{
            return $user->getMainChannel()->avatar;
        }
    }
    
    public static function getShownName($user){
        if(isset($user->details->shown_name)){
            return $user->details->shown_name;
        }else{
            return $user->username;
        }
    }

    public static function getDescription($user){
        if(isset($user->details->description)){
            return $user->details->description;
        }else{
            return '';
        }
    }
}
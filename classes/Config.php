<?php

class Config {
    
    /*
    *  @return the config value at the given path (from the $GLOBALS['config'] array)
    */
    public static function get($path) {
        if($path) {
            $config = $GLOBALS['config'];
            $path = explode('/', $path);
            
            foreach($path as $char) {
                if(isset($config[$char])) {
                    $config = $config[$char];
                }
            }
            
            return $config;
        }
    }
}

?>
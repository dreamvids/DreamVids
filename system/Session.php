<?php

/**
 * Class Session
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the ./LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) DreamVids
 * @link          http://dreamvids.fr DreamVids(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace System;

/**
 * Class Session
 * @package System
 */
class Session{
    /**
     * Check if session is started
     * @return bool
     */
    public static function check(){
        return !isset($_SESSION) ? session_start() : false;
    }

    /**
     * Get a id in sessions
     * @return bool|string
     */
    public static function getSessionId(){
        return !is_null(session_id()) ? session_id() : false;
    }

    /**
     * Generate an id for your sessions
     * @param bool $type
     * @return bool
     */
    public static function regenerateId($type = true){
        return $type == true ? session_regenerate_id(true) : session_regenerate_id();
    }

    /**
     * Check if a key exists
     * @param $name
     * @return bool
     */
    public static function exists($name){
        return array_key_exists($name, $_SESSION) ? true : false;
    }

    /**
     * Add a key in sessions
     * @param $key
     * @param $value
     */
    public static function set($key, $value){
        $_SESSION[$key] = $value;
    }

    /**
     * Get a key in sessions
     * @param $key
     * @return bool
     */
    public static function get($key){
        return isset($_SESSION[$key]) ? $_SESSION[$key] : false;
    }

    /**
     * Get all sessions
     * @return string
     */
    public static function getAll(){
        return !empty($_SESSION) ? $_SESSION : 'Session vide';
    }

    /**
     * Removing a key in sessions
     * @param $key
     */
    public static function remove($key){
        unset($_SESSION[$key]);
    }

    /**
     * Remove all sessions
     * @param bool $type
     * @return bool|void
     */
    public static function removeAll($type = false){
        return $type === false ? session_destroy() : session_unset();
    }
}
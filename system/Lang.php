<?php

/**
 * Created by PhpStorm.
 * User: peter_000
 * Date: 14/07/2016
 * Time: 19:55
 */
class Lang {
    private static $lang = null;

    private function __construct() {
    }

    public static function get(): stdClass {
        if (self::$lang == null) {
            self::$lang = json_decode(file_get_contents(LANGDIR.LANG.'.json'));
        }

        return self::$lang;
    }
}
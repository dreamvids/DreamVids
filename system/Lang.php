<?php

class Lang {
    private static $lang = null;

    private function __construct() {}

    public static function get(): stdClass {
        if (self::$lang == null) {
            self::$lang = json_decode(file_get_contents(LANGDIR.LANG.'.json'));
        }

        return self::$lang;
    }
}
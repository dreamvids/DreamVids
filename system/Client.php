<?php

class Client {
    private static $instance = null;

    private function __construct() {}

    public static function get(): \DreamVids\API\Client {
        if (self::$instance == null) {
            self::$instance = new \DreamVids\API\Client(
                '9b55842ccdb4aae14fda2b22098eb9e682cb2b2c9f74d638f8292b4956af583eafb6e5567d5b1192e91ce37c08cae496d4c18fdcf8f411b304ddd8593a892475',
                '7746c0d84f7448c8fccc2104ee927d56c39825413296ebd30a926bcdbc70b9f2bf7081b13acdcdfc52f95019a155192d5a90d033f099f63acd207a4c1fe64852',
                'root',
                'localhost'
            );
        }

        return self::$instance;
    }
}
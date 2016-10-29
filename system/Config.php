<?php

/**
 * Class Config
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

class Config{

    public function __construct(){}

    /**
     * Get a value in array
     * @param $name
     * @param null $default
     * @return mixed|null
     */
    public static function get($name, $default = null){
        $path = explode('.', $name);
        $value =  include BASE . 'config/app.php';

        foreach ($path as $param) {
            return isset($value[$param]) ? $value = $value[$param] : $default;
        }

        return $value;
    }
}
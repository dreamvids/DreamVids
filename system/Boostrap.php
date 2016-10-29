<?php

/**
 * Class Boostrap
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

class Boostrap{

    /**
     * Launch the website
     */
    public function run(){

        // Session
        Session::check();

        // Define
        $this->defineList();
    }

    /**
     * List of all define
     */
    public function defineList(){
        define('BASE', str_replace('public', '', $_SERVER['DOCUMENT_ROOT']));
        define('DS', DIRECTORY_SEPARATOR);

        // folder home/
        define('PATH_APP', BASE . 'app' . DS);
        define('PATH_CONFIG', BASE . 'config' . DS);
        define('PATH_PUBLIC', BASE . 'public' . DS);
        define('PATH_SYSTEM', BASE . 'system' . DS);

        // folder app/
        define('PATH_APP_CONTROLLERS', PATH_APP . 'controllers' . DS);
        define('PATH_APP_LANGS', PATH_APP . 'langs' . DS);
        define('PATH_APP_VIEWS', PATH_APP . 'views' . DS);

        // folder public/
        define('PATH_PUBLIC_CSS', PATH_PUBLIC . 'css' . DS);
        define('PATH_PUBLIC_IMG', PATH_PUBLIC . 'img' . DS);
        define('PATH_PUBLIC_JS', PATH_PUBLIC . 'js' . DS);
    }
}
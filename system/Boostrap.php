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
    }
}
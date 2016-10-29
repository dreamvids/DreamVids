<?php

/**
 * Welcome to the index
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the ./LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) DreamVids
 * @link          http://dreamvids.fr DreamVids(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

require str_replace('public', '', $_SERVER['DOCUMENT_ROOT']) . 'vendor/autoload.php';

/*************************
 *       Boostrap        *
 ************************/

use System\Boostrap;

$boostrap = new Boostrap();
$boostrap->run();
<?php

/**
 * Routes configuration
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the ./LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) DreamVids
 * @link          http://dreamvids.fr DreamVids(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

Route::get('/', 'HomeController@index');
Route::get('/user', 'UserController@index');
Route::get('/user/:id', 'UserController@profile');
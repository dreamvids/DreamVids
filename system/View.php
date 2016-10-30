<?php

/**
 * Class View
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

class View{

    protected $viewPath  = PATH_APP_VIEWS;
    protected $layout    = 'default';
    protected $extension = 'php';

    public function __construct($viewPath = null, $layout = null){
        $this->viewPath = $viewPath;
        $this->layout   = $layout;
    }

    /**
     * Render a view
     * @param $view
     * @param null $vars
     */
    public function render($view, $vars = null){
        if(!is_null($vars)){
            extract($vars);
        }

        $view = str_replace('.', '/', $view);
        ob_start();

        require $this->viewPath . $view . '.'.$this->extension;
        $content = ob_get_clean();

        require $this->viewPath . 'layouts/' . $this->layout . '.'.$this->extension;
    }
}
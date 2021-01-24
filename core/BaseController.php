<?php

namespace Core;

use stdClass;

abstract class BaseController
{
    protected $view;
    private $viewPath;
    function __construct()
    {
        $this->view = new stdClass;
    }
    protected function renderView($viewPath, $layoutpath = null)
    {
        $this->viewPath = $viewPath;
        $this->content();

    }
    protected function content()
    {
        if (\file_exists(__DIR__ . "/../app/Views/{$this->viewPath}.phtml")) {

            require_once __DIR__ . "/../app/Views/{$this->viewPath}.phtml";
        } else {
            echo "Error view not found";
        }

    }
}

<?php

namespace appEngine\App\Controllers;

use appEngine\App\Views as View;

abstract class Controller
{
    protected $twig;

    protected $view;

    protected function createView($template, $data)
    {
        $this->view = new View\View($this->twig, $template, $data);
    }
}

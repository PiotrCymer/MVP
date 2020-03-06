<?php

namespace appEngine\App\Views;

class View
{
    public function __construct($twigObject, $template, $data)
    {
        $this->twig = $twigObject;
        $this->template = $template;
        $this->data = $data;
        $this->renderView();
    }

    private function renderView()
    {
        echo $this->twig->render($this->template, $this->data);
    }
}

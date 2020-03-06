<?php

namespace appEngine\App\Controllers;

use appEngine\App\Interfaces as IInterface;

class FirstController extends Controller
{
    protected $twig;

    private $model;

    public function __construct($twigObject, IInterface\ModelInterface $model)
    {
        $this->twig = $twigObject;
        $this->model = $model;
    }

    public function index()
    {
        $dataToView = $this->model->getDataToView();
        $this->view = $this->createView("test.html.twig", $dataToView);
    }
}

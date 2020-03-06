<?php

namespace appEngine\App\Controllers;

use appEngine\App\Interfaces as IInterface;

class SinglePlantController extends Controller
{
    protected $twig;

    private $model;

    public function __construct($twigObject, IInterface\ModelInterface $model, $params = null)
    {
        $this->twig = $twigObject;
        $this->model = $model;
        $this->param = $params;
    }

    public function index()
    {
        $singlePlant = $this->model->getSinglePlant($this->param['id']);
        $this->model->addData("singlePlant", $singlePlant);
        $dataToView = $this->model->getDataToView();
        $this->view = $this->createView("single-plant.html.twig", $dataToView);
    }
}

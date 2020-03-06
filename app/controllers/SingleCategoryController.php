<?php

namespace appEngine\App\Controllers;

use appEngine\App\Interfaces as IInterface;


class SingleCategoryController extends Controller
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
        $categories = $this->model->getCategoriesList();
        $plants = $this->model->getCategoryPlants($this->param['id']);
        $singleCategory = $this->model->getSingleCategory($this->param['id']);
        $this->model->addData("singleCategory", $singleCategory);
        $this->model->addData("categories", $categories);
        $this->model->addData("plants", $plants);
        $dataToView = $this->model->getDataToView();
        $this->view = $this->createView("single-category.html.twig", $dataToView);
    }
}

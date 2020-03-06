<?php

namespace appEngine\Core\K;

use appEngine\Core\Router as Router;
use appEngine\App\Controllers as Controller;
use appEngine\App\Config as Config;

use \Exception;

class Kernel
{
    public $config;

    public $router;

    private $controllerName;

    private $methodName;

    private $twig;

    public $params = null;


    public function __construct()
    {
        $request =  $_SERVER["REQUEST_URI"];
        if(explode(":", $_SERVER["HTTP_HOST"])[0] == "localhost") {
          $this->url = strtr($request, array("/mvp" => "", "/MVP" => ""));
        } else {
          $this->url = $request;
        }
        $this->parseConfigFile();
        $this->initTwig();
    }

    private function parseConfigFile()
    {
      $configArray = include("/home/users/webs/piotrc/dev/projekt/app/config.php");
      //$configArray = include("/opt/lampp/htdocs/mvp/app/config.php");

      $this->config = Config\Config::getInstance($configArray);
    }

    public function run()
    {
        $this->initRouter();
    }

    private function initRouter()
    {
        //$routesCollectionArray = include("/opt/lampp/htdocs/mvp/core/routing/RoutesArray.php");
        $routesCollectionArray = include("/home/users/webs/piotrc/dev/projekt/core/routing/RoutesArray.php");
        $routesCollection = new Router\RoutesCollection($routesCollectionArray);
        $routesCollection->initCollection();
        $this->router = Router\Router::getInstance($this->url);
        $this->router->addCollection($routesCollection);


        if ($this->router->run()) {
            $this->controllerName = $this->router->getClass();
            $this->methodName = $this->router->getMethod();
            $this->modelName = $this->router->getModel();
            $this->params = $this->router->getParams();
        } else {
            $this->controllerName = 'appEngine\App\Controllers\IndexController';
            $this->methodName = 'error404';
            $this->modelName = 'appEngine\App\Models\IndexModel';
        }
        $this->initController();
    }

    private function initTwig()
    {

        $filter = new \Twig_SimpleFilter('nameToUrl', function ($string) {

            $tmp = strtr($string, array(" " => "-", "ą" => "a", "ć" => "c", "ę" => "e", "ł" => "l", "ń" => "n", "ó" => "o", "ś" => "s", "ż" => "z", "ź" => "z"));
            $url = strtolower($tmp);
            return $url;
        });


         $loader = new \Twig_Loader_Filesystem("/home/users/webs/piotrc/dev/projekt/app/views");
        //$loader = new \Twig_Loader_Filesystem("/opt/lampp/htdocs/mvp/app/views");

        $this->twig = new \Twig_Environment($loader, [
            'debug' => true,
        ]);

        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        $this->twig->addFilter($filter);
    }

    private function initController()
    {

        try {
            if ($this->controllerName == '') {
                throw new Exception();
            }

            $this->model = new $this->modelName();
            if ($this->params != null) {
                $this->controller = new $this->controllerName($this->twig, $this->model, $this->params);
            } else {
                $this->controller = new $this->controllerName($this->twig, $this->model);
            }

            $method = $this->methodName;
            $this->controller->$method();
        } catch (Exception $e) { }
    }
}

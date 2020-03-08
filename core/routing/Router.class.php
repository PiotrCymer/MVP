<?php

namespace appEngine\Core\Router;

class Router
{

    protected $url;

    private $collection;

    protected $file;

    protected $class;

    protected $method;

    public static $instance;

    private $type;

    private $model;

    private function __construct($url)
    {
        $url = explode('?', $url);
        $this->url = $url[0];
    }

    public static function getInstance(string $url)
    {
        if (self::$instance === null) {
            self::$instance = new Router($url);
        }
        return self::$instance;
    }

    public function addCollection(RoutesCollection $collection)
    {
        $this->collection = $collection;
    }

    public function getCollection() : RoutesCollection
    {
        return $this->collection;
    }

    public function setClass(string $class)
    {
        $this->class = $class;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getParams()
    {
       // return $this->params;
    }

    protected function  matchRoute(Route $route)
    {
        $explodeUrl =  explode("/", $this->url);
        $explodePattern = explode("/", $route->getPath());

        if ((count($explodeUrl) == count($explodePattern)) && $route->getType() == "subpage") {
            foreach ($explodeUrl as $k => $v) {
                if ($k == 0) {
                    continue;
                } else {
                    if (strpos($explodePattern[$k], "%") === false) {
                        $explodePattern[$k] = "%" . $explodePattern[$k] . "%";
                    }
                    if (preg_match("#^\d+$#", $explodeUrl[$k])) {
                        $param['id'] = $explodeUrl[$k];
                    }
                    if (!preg_match($explodePattern[$k], $explodeUrl[$k])) {
                        return false;
                    } else if (preg_match($explodePattern[$k], $explodeUrl[$k]) && $k == $this->getLastIndex($explodeUrl)) {
                        $this->class = $route->getClass();
                        $this->method = $route->getMethod();
                        $this->model = $route->getModel();
                        $this->params = $param;
                        return true;
                    }
                }
            }
        } else {
            if ($this->url == $route->getPath()) {
                if($route->getType() == 'api') {
                    $this->params = $route;
                } else {
                    $this->params = null;
                }
                $this->class = $route->getClass();
                $this->method = $route->getMethod();
                $this->model = $route->getModel();
                $this->type = $route->getType();
                return true;
            }
        }
        return false;
    }

    public function run()
    {
      $routesCollectionObject = $this->getCollection();

        foreach ($routesCollectionObject->collection as $route) {
            if ($this->matchRoute($route)) {
                return true;
            }
        }
        return false;
    }

    private function getLastIndex($array)
    {
        $cnt = count($array);

        foreach ($array as $k => $v) {
            if ($k + 1 == $cnt) {
                return $k;
            }
        }
        return false;
    }
}

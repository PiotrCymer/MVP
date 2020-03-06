<?php

namespace appEngine\Core\Router;

class Route
{


    protected $className;

    protected $method;


    public function __construct($path, $config, $params = array(), $defaults = array())
    {
        $this->path = $path;
        $this->method = $config['method'];
        $this->className = $config['class'];
        $this->modelName = $config['model'];
        $this->routeType = $config['type'];
    }

    public function getClass()
    {
        return $this->className;
    }

    public function getModel()
    {
        return $this->modelName;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setPath($path)
    {
        $this->path = HTTP_SERVER . $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getType()
    {
        return $this->routeType;
    }
}

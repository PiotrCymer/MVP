<?php

class Autoload
{
    private $config;

    
    public function __construct($config)
    {
        $this->config = $config;
    }
    public function run()
    {
        spl_autoload_register(array($this, "load"));
    }

    private function load($file)
    {

       foreach($this->config as $k) {
            if(file_exists($k."\\".$file.".class.php")) {
                include($k."\\".$file.".class.php");
                break;
            }
       }
        
    }

}
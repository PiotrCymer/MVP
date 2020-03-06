<?php
namespace appEngine\App\Config;
class Config
{
    private static $instance;

    private $configArray;

    private function __construct($configArray)
    {
        $this->configArray = $configArray;
    }

    public static function getInstance($param = "/home/users/webs/piotrc/dev/projekt/app/config.php")
    {
        if (self::$instance === null) {
            self::$instance = new Config($param);
        }
        return self::$instance;
    }

    public function get($key, $value = null)
    {
        if ($value == null) {
           return $this->configArray[$key];
        } else {
            foreach ($this->configArray[$key] as $k => $v) {
                if ($k == $value) {
                    return $v;
                }
            }
        }
    }
}

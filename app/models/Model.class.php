<?php

namespace appEngine\App\Models;
use appEngine\Core\Database as Database;

abstract class Model
{
    protected $dataToView;

    protected function getDbConn()
    {
        $dbConn = Database\Database::getInstance();

        return $dbConn;
    }

    public function getDataToView()
    {
        return $this->dataToView;
    }

    public function addData($key, $value)
    {
        $this->dataToView[$key] = $value;
    }
    public function pre($data)
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }
}

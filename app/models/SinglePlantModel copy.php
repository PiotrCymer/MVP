<?php

namespace appEngine\App\Models;

use appEngine\App\Interfaces as IInterface;

class SinglePlantModel extends Model implements IInterface\ModelInterface
{

    public function __construct()
    {
        $this->dbConn = parent::getDbConn();
        $this->dataToView  =  array();
    }

    public function getSinglePlant($plantId)
    {
        return $this->dbConn->getSingleRow("SELECT * FROM plants WHERE id = {$plantId}");
    }
}

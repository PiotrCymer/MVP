<?php

namespace appEngine\App\Models;

use appEngine\App\Interfaces as IInterface;

class IndexModel extends Model implements IInterface\ModelInterface
{

    public function __construct()
    {
        $this->dbConn = parent::getDbConn();
        $this->dataToView  =  array();

    }

    public function getExamplePlants()
    {
        return $this->dbConn->getTable("SELECT * FROM plants LIMIT 3");
    }
    public function getGalleryItems()
    {
        return $this->dbConn->getTable("SELECT * FROM gallery");
    }
}

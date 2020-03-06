<?php

namespace appEngine\App\Models;

use appEngine\App\Interfaces as IInterface;

class SingleCategoryModel extends Model implements IInterface\ModelInterface
{

    public function __construct()
    {
        $this->dbConn = parent::getDbConn();
        $this->dataToView  =  array();
    }

    public function getCategoriesList()
    {
        return $this->dbConn->getTable("SELECT * FROM plants_categories");
    }

    public function getSingleCategory($categoryId)
    {
        return $this->dbConn->getSingleRow("SELECT * FROM plants_categories WHERE id = {$categoryId}");
    }

    public function getCategoryPlants($categoryId)
    {
        return $this->dbConn->getTable("SELECT * FROM plants WHERE category_id = {$categoryId}");
    }
}

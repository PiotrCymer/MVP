<?php

namespace appEngine\App\Models;

use appEngine\App\Interfaces as IInterface;

class ApiModel extends Model implements IInterface\ModelInterface
{

    /**
     * @var \appEngine\Core\Database\Database
     */
    private $dbConn;

    public function __construct()
    {
        $this->dbConn = parent::getDbConn();
        $this->dataToView  =  array();
    }

    public function getPlants()
    {
        $plants = $this->dbConn->getTable("SELECT * FROM plants");
        $categoriesNames = $this->getPlantCategoriesNames();
  
        foreach($plants as $k => $v) {
            $plants[$k]['category_name'] = $categoriesNames[$v['category_id']];
        }

        return $plants;
    }

    public function getPlantCategoriesNames()
    {
        $names = $this->dbConn->getTable("SELECT id, name FROM plants_categories");
        $return = array();

        foreach($names as $k => $v) {
            $return[$v['id']] = $v['name'];
        }
        return $return;
    }
    public function getPlantCategories()
    {
        $return = $this->dbConn->getTable("SELECT * FROM plants_categories");

        return $return;
    }

    public function getPlant($id)
    {
        $plant = $this->dbConn->getSingleRow("SELECT * FROM plants WHERE id = {$id} LIMIT 1");
        $categoriesNames = $this->getPlantCategoriesNames();
        $plant['category_name'] = $categoriesNames[$plant['category_id']];

        return $plant;
    }

    public function updatePlant($plantId, $name, $categoryId)
    {
        $updateData = array(
            "name" => $name,
            "category_id" => $categoryId
        );
        $where = " id = {$plantId}";
        $this->dbConn->updateRecord('plants', $updateData, $where);
    }

    public function addPlant($name, $description, $categoryId, $insolation, $humidity, $temperature, $difiiculty)
    {
        $insertData = array(
            "name" => $name,
            "description" => $description,
            "category_id" => $categoryId,
            "insolation" => $insolation,
            "humidity" => $humidity,
            "temperature" => $temperature,
            "difficulty" => $difiiculty
        );

        $this->dbConn->insertRecord('plants', $insertData);
    }

    public function checkUserCredentials($login, $password)
    {
        $loginSanitaze = mysqli_real_escape_string($this->dbConn->connection, $login );
        $passSanitaze = mysqli_real_escape_string($this->dbConn->connection, $password);

        $check = $this->dbConn->query("SELECT * FROM users WHERE login = '{$loginSanitaze}' AND password = '{$passSanitaze}'");

        if($check) {
            return true;
        }
        return false;
    }


}

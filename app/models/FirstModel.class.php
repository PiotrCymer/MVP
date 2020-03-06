<?php
namespace appEngine\App\Models;
use appEngine\App\Interfaces as IInterface;

class FirstModel extends Model implements IInterface\ModelInterface
{

    public function __construct()
    {
        $this->dbConn = parent::getDbConn();
        $this->dataToView  =  $this->dbConn->getTable("SELECT * FROM test");
        //$this->dataToView  =  array("test" => "Work");
       
    }

    public function getDataToView()
    {
        return $this->dataToView;
    }
}

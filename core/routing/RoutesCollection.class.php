<?php
namespace appEngine\Core\Router;


class RoutesCollection
{
  private $collectionArray;

  public $collection;

  public function __construct( array $routesCollectionArray)
  {
    $this->collectionArray = $routesCollectionArray;
  }

  public function getCollectionArray()
  {
    return $this->collectionArray;
  }

  public function getCollection()
  {
    return $this->collection;
  }

  public function initCollection()
  {
    foreach($this->collectionArray as $k => $v) {
      
      $this->collection[$k] = new Route($v['url'], $v['routerObject']);

    }
  }

  // $this->router->add('api-add-plant', new Router\Route(
  //     '/api/addplant',
  //     array(
  //         'class' => 'appEngine\App\Controllers\ApiController',
  //         'method' => 'addPlant',
  //         'model' => 'appEngine\App\Models\ApiModel',
  //         'type' => 'api'
  //     )
  // ));
}


 ?>

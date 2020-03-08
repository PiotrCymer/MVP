<?php

namespace appEngine\App\Controllers;

use appEngine\App\Interfaces as IInterface;
use appEngine\Core\helpers as Helpers;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, PUT, OPTIONS, POST");
header("Access-Control-Allow-Headers: content-type, authorization");
header("Content-Type: application/json");




class ApiController extends Controller
{
    protected $twig;

    private $model;

    private $requestMethodArray;

    private $credentials;

    private $currentRoute;

    private $errorIssue;



    public function __construct($twigObject, IInterface\ModelInterface $model, $params = null)
    {
        $this->twig = $twigObject;
        $this->model = $model;
        $this->currentRoute = $params;

       switch($_SERVER['REQUEST_METHOD']) {
            case 'GET' :

                $this->requestMethodArray = $_GET;
                break;

            case 'POST':
                $postdata = file_get_contents("php://input");
                $data = json_decode($postdata);

                $this->requestMethodArray = $this->objectToArray($data);
                break;

           default:

               break;
        }
       $this->credentials = $this->checkCredentials();

       if(!$this->credentials) {
            echo $this->encode(array("error" => $this->errorIssue));
            exit();
       }
    }

    private function checkCredentials() : bool
    {
        if($this->currentRoute->getMethod() == 'login') {
            if(isset($this->requestMethodArray['login'], $this->requestMethodArray['password'])){
                return true;
            } else {
                //$this->errorIssue = $this->requestMethodArray;
                $this->errorIssue = "No login or password1";
            }
        } else {
            if($_SERVER['HTTP_AUTHORIZATION']) {
                if(Helpers\Token::validateToken($_SERVER['HTTP_AUTHORIZATION'])) {
                    return true;
                } else {
                    $this->errorIssue = "INCORRECT AUTHORIZATION TOKEN";
                }
            } else {
                $this->errorIssue = "No AUTHORIZATION HEADER";
            }
        }
        return false;
    }



    public function test()
    {
        echo $this->encode("WORK");

    }

    public function login()
    {
        if(isset($this->requestMethodArray['login'], $this->requestMethodArray['password'])) {
            $login = $this->requestMethodArray['login'];
            $pass = $this->requestMethodArray['password'];
            if($this->model->checkUserCredentials($login, $pass)) {
                $this->token = Helpers\Token::generate(base64_encode($login.$pass));
                echo $this->encode(array("message" => "LOGIN DONE", "auth_token" => Helpers\Token::getToken()));
                return true;
            } else {
                $this->errorIssue = "Incorrect CREDENTIALS";
            }
        } else {
            $this->errorIssue = "No password or login2";
        }
        echo $this->encode(array("error" => $this->errorIssue));
        return false;
    }

    public function getPlants()
    {
        $plants = $this->model->getPlants();
        echo $this->encode($plants);
    }

    public function getSinglePlant()
    {
        if ($this->requestMethodArray['plantId']) {
            $id = $this->requestMethodArray['plantId'];
            $categories = $this->model->getPlantCategories();
            $plant = $this->model->getPlant($id);
            $dataToSend = array(
                "plant" => $plant,
                "categories" => $categories
            );
            echo $this->encode($dataToSend);
        } else {
            echo $this->encode(array("error" => "ERRROR"));
        }
    }
    public function updatePlant()
    {
        if (isset($this->get['plantId'], $this->requestMethodArray['name'], $this->requestMethodArray['categoryId'])) {
            $this->model->updatePlant($this->requestMethodArray['plantId'], $this->requestMethodArray['name'], $this->requestMethodArray['categoryId']);
            echo $this->encode(array($this->requestMethodArray['name']));
        } else {
            echo $this->encode(array("error" => "ERRROR"));
        }
    }
    public function getCategories()
    {
        $return = $this->model->getPlantCategories();

        echo $this->encode($return);
    }

    public function addPlant()
    {
        if(isset($this->get['name'], $this->get['description'], $this->get['categoryId'],$this->get['insolation'],$this->get['humidity'],$this->get['temperature'],$this->get['difficulty'])) {
            $this->model->addPlant($this->get['name'], $this->get['description'], $this->get['categoryId'],$this->get['insolation'],$this->get['humidity'],$this->get['temperature'],$this->get['difficulty']);
        } else {
            echo $this->encode(array("error" => "ERRROR"));

        }
    }

    private function encode($data)
    {
        return json_encode($data);
    }


    public function objectToArray($stdObject) {
        if (is_object($stdObject)) {
            $stdObject = get_object_vars($stdObject);
        }

        if (is_array($stdObject)) {
            return array_map(__METHOD__, $stdObject);
        } else {
            return $stdObject;
        }
    }
}

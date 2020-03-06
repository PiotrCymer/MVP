<?php

namespace appEngine\App\Controllers;

use appEngine\App\Interfaces as IInterface;

class IndexController extends Controller
{
    protected $twig;

    private $model;

    public function __construct($twigObject, IInterface\ModelInterface $model)
    {
        $this->twig = $twigObject;
        $this->model = $model;

    }

    public function index()
    {
        $exampleProducts = $this->model->getExamplePlants();
        $galleryItems = $this->model->getGalleryItems();
        $this->model->addData("examplePlants", $exampleProducts);
        $this->model->addData("galleryItems", $galleryItems);
        $dataToView = $this->model->getDataToView();
        $this->view = $this->createView("main.html.twig", $dataToView);
    }

    public function contact()
    {
        $dataToView = $this->model->getDataToView();
        $this->view = $this->createView("contact.html.twig", $dataToView);
    }

    public function send()
    {
        if (isset($_POST['name'], $_POST['email'], $_POST['message'])) {
            $message = $_POST['message'];
            $email = $_POST['email'];
            $name = $_POST['name'];

            $encoding = "utf-8";
            $message = "Wiadomość od: " . $name . "\r\nWiadomość: \r\n" . $message . "";
            $header = "Content-type: text/plain; charset=" . $encoding . " \r\n";
            $header .= 'From:' . $email;

            if (mail("piotr@cymer.pl", 'Wiadomość z formularza kontaktowego', $message, $header)) {
               echo "Wiadomość wysłana pomyślnie";
               exit();
            } else {
                
                echo "Nie udało się wysłać wiadomości, prosimy spróbować ponownie.";
            }
        } else {
            echo "Nie udało się wysłać wiadomości, prosimy spróbować ponownie";
        }
    }

    public function error404()
    {
        $this->view = $this->createView("error404.html.twig", $dataToView = array());
    }
}

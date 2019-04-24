<?php

namespace App\Controller;

use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainPageController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function sendMail(FileUploader $fileUploader)
    {
        var_dump($fileUploader);
        return $this->render('general/index.html.twig');
    }
}

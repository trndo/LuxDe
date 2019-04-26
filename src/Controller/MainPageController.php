<?php

namespace App\Controller;

use App\Service\FileUploader;
use App\Service\MailSender;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainPageController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('general/index.html.twig');

    }

    /**
     * @Route("/send", name="send")
     */
    public function send(Request $request)
    {
        return $this->render('general/index.html.twig');
    }

    /**
     * @Route("/sendFast", name="sendFast")
     */
    public function sendFast(MailSender $mailSender,Request $request)
    {
        $mail = $request->request->get('email');
        $mailSender->sendFastMessage($mail);

        return new JsonResponse([
            'mail' => $mail
        ]);
    }
}

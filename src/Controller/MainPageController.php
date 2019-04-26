<?php

namespace App\Controller;

use App\Entity\Mail;
use App\Service\MailSender;
use Doctrine\ORM\EntityManagerInterface;
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
    public function send(Request $request,EntityManagerInterface $em,Mail $mail,MailSender $mailSender)
    {
        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $phone = $request->request->get('phone');

            $data = $mail->setName($name)
                ->setPhoneNumber($phone)
                ->setEmail($email);

            $em->persist($data);
            $em->flush();

            $mailSender->sendMessage($data);

        return new JsonResponse([
            'mail' => $email
        ]);
    }

//    /**
//     * @Route("/sendFast", name="sendFast")
//     */
//    public function sendFast(MailSender $mailSender,Request $request)
//    {
//        $email = $request->request->get('email');
//        $mailSender->sendFastMessage($email);
//
//        return new JsonResponse([
//            'mail' => $email
//        ]);
//    }
}

<?php

declare(strict_types=1);

/*
 * This file is part of the "LuxDe School" package.
 * (c) Gopkalo Vitaliy <trndogv@gmail.com>
 */

namespace App\Controller;

use App\Entity\Mail;
use App\Repository\SettingsRepository;
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
    public function home(SettingsRepository $repository)
    {
        $settings = $repository->findOneBy([], ['id' => 'DESC']);

        return $this->render('general/general.html.twig', [
                'settings' => $settings,
        ]);
    }

    /**
     * @Route("/send", name="send")
     */
    public function send(Request $request, EntityManagerInterface $em, MailSender $mailSender)
    {
        $mail = new Mail();
        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $phone = $request->request->get('phone');

        if ($name && $email && $phone) {
            $data = $mail->setName($name)
                ->setPhoneNumber($phone)
                ->setEmail($email);

            $em->persist($data);
            $em->flush();

            $mailSender->sendMessage($data);

            return new JsonResponse([
                'mail' => $email,
            ]);
        }

        return new JsonResponse([
            'error' => 'Invalid data',
        ], 500);
    }

    /**
     * @Route("/sendFast", name="sendFast")
     */
    public function sendFast(MailSender $mailSender, Request $request)
    {
        $email = $request->request->get('email');
        $mailSender->sendFastMessage($email);

        return new JsonResponse([
            'mail' => $email,
        ]);
    }
}

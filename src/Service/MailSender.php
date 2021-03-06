<?php

declare(strict_types=1);

/*
 * This file is part of the "LuxDe School" package.
 * (c) Gopkalo Vitaliy <trndogv@gmail.com>
 */

namespace App\Service;

use App\Entity\Mail;
use Twig\Environment;

class MailSender
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $environment;

    public function __construct(\Swift_Mailer $mailer, Environment $environment)
    {
        $this->mailer = $mailer;
        $this->environment = $environment;
    }

    public function sendMessage(Mail $data)
    {
        $messToMe = (new \Swift_Message('Lux-De Order'))
            ->setFrom('luxdeinf@gmail.com')
            ->setTo('luxdeinf@gmail.com')
            ->setBody(
                $data->getName() . '<br>' . $data->getEmail() . '<br>' . $data->getPhoneNumber(),
                'text/html'
            );
        $messToCustomer = (new \Swift_Message('Lux-De School'))
            ->setFrom('luxdeschool@gmail.com')
            ->setTo($data->getEmail())
            ->setBody(
                $this->environment->render(
                    '_mail.html.twig'
                ),
                'text/html'
            );
        $this->mailer->send($messToMe);
        $this->mailer->send($messToCustomer);
    }

    public function sendFastMessage(string $email)
    {
        $message1 = (new \Swift_Message('Lux-De Order'))
            ->setFrom('luxdeinf@gmail.com')
            ->setTo('luxdeinf@gmail.com')
            ->setBody(
                "Пользователь $email отправил сообщение. Отпишите ему!",
                'text/html'
            );
        $message2 = (new \Swift_Message('Lux-De School'))
            ->setFrom('luxdeinf@gmail.com')
            ->setTo($email)
            ->setBody(
                $this->environment->render(
                    '_mail.html.twig'
                ),
                'text/html'
            );
        $this->mailer->send($message1);
        $this->mailer->send($message2);
    }
}

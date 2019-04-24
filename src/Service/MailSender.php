<?php


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
        $message1 = (new \Swift_Message('Lux-de Order'))
            ->setFrom('luxdeschool@gmail.com')
            ->setTo('luxdeschool@gmail.com')
            ->setBody(
                $data->getName().'<br>'.$data->getEmail().'<br>'.$data->getPhoneNumber().'<br>'.$data->getMessage(),
                'text/html'
            );
        $message2 = (new \Swift_Message('Web-studio OctoWice'))
            ->setFrom('luxdeschool@gmail.com')
            ->setTo($data->getEmail())
            ->setBody(
                $this->environment->render(
                    'mail.html.twig'
                )
                ,
                'text/html');
        $this->mailer->send($message1);
        $this->mailer->send($message2);
    }
}
<?php


namespace App\Controller\Admin;


use App\Repository\ArticleRepository;
use App\Repository\MailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShowAdminController extends AbstractController
{
    /**
     * @Route("/admin/mail", name="mail")
     */
    public function showMails(MailRepository $repository)
    {
        $messages = $repository->findBy([],['id' => 'DESC']);

        return $this->render('admin/journal.html.twig',[
            'messages' => $messages,
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function showArticles(ArticleRepository $repository)
    {
        $article = $repository->findBy([],['id' => 'DESC']);

        return $this->render('admin/article.html.twig',[
            'articles' => $article,
        ]);
    }

}
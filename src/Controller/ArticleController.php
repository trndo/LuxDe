<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/blog/{slug}", name="article")
     */
    public function showArticle(Article $article)
    {
        return $this->render('article/index.html.twig',[
            'article' => $article
        ]);
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function showAllArticles(ArticleRepository $repository,PaginatorInterface $paginator,Request $request)
    {
        $query = $repository->findBy([],['id' => 'DESC']);
        $articles = $paginator->paginate(
            $query,
            $request->query->getInt('page',1),
            1
        );

        return $this->render('blog/index.html.twig',[
            'articles' => $articles
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\SettingsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/blog/{slug}", name="article")
     */
    public function showArticle(Article $article,SettingsRepository $repository)
    {
        $settings = $repository->findOneBy([],['id' => 'DESC']);
        return $this->render('article/article.html.twig',[
            'article' => $article,
            'settings' => $settings
        ]);
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function showAllArticles(ArticleRepository $articleRepository,PaginatorInterface $paginator,Request $request,SettingsRepository $settingsRepository)
    {
        $settings = $settingsRepository->findOneBy([],['id' => 'DESC']);
        $query = $articleRepository->findBy([],['id' => 'DESC']);
        $articles = $paginator->paginate(
            $query,
            $request->query->getInt('page',1),
            1
        );

        return $this->render('blog/blog.html.twig',[
            'articles' => $articles,
            'settings' => $settings
        ]);
    }
}

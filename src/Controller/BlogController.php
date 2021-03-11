<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @param ArticleRepository $repo
     * @return Response
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo): Response
    {
        $articles = $repo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles,
        ]);
    }

    /**
     * @return Response
     * @Route("/",name="home")
     */
    public function home():Response
    {
        return $this->render('blog/home.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @param Article $article
     * @return Response
     * @Route("/blog/{id}",name="blog_show")
     */
    public function show(Article $article):Response
    {
        return $this->render('blog/show.html.twig', [
            'article' => $article,
        ]);
    }
}

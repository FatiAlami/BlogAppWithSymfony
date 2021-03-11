<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
     * @return Response
     * @Route("/blog/new",name="blog_create")
     */
    public function create(): Response
    {
        $article = new Article();
        $form = $this->createFormBuilder($article)
            ->add('title')
            ->add('content',TextareaType::class,[
                'attr' => [
                    'placeholder' => "Contenu de l'article",
                ]
            ])
            ->add('image')
            ->getForm();
        return $this->render('blog/create.html.twig',[
            'form' => $form->createView()
        ]);
    }


    /**
     * @param Article $article
     * @return Response
     * @Route("/blog/{id}",name="blog_show")
     */
    public function show(Article $article):Response
    {
        if (!$article) {
            throw $this->createNotFoundException(
                'No article found for id '
            );
        }
        return $this->render('blog/show.html.twig', [
            'article' => $article,
        ]);
    }
}

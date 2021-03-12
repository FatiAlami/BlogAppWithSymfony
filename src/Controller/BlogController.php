<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Article|null $article
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     * @Route("/blog/new",name="blog_create")
     * @Route("/blog/{id}/update",name="blog_edit")
     */
    public function create(Request $request, EntityManagerInterface $manager, Article $article = null): Response
    {
        if (!$article){
            $article = new Article();
        }
        $form = $this->createForm(ArticleType::class,$article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if(!$article->getId())
                $article->setCreatedAt(new \DateTime());
            $manager->persist($article);
            $manager->flush();

             return $this->redirectToRoute('blog_show',['id' => $article->getId()]);
        }

        return $this->render('blog/create.html.twig',[
            'form' => $form->createView(),
            'modeEdit' => $article->getId() !== null
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

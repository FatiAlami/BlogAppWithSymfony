<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=0; $i<10; $i++){
            $article = new Article();
            $article->setTitle("Titre de l'article n $i")
                    ->setContent("<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>")
                    ->setImage("http://placehold.it/350")
                    ->setCreatedAt(new \DateTime());

            $manager->persist($article);
        }
        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $faker;
    const NB_CATEGORIES = 6;
    const NB = 1;

    public function __construct(){
        $this->faker = Factory::create();
    }

    /**
     * Performs the loading of fake data.
     *
     * @param ObjectManager $manager the object manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadCategories($manager);
        $this->loadArticles($manager);
        $this->loadComments($manager);
        $manager->flush();
    }

    /**
     * Loads some dummy categories.
     *
     * @param ObjectManager $manager the object manager
     */
    private function loadCategories(ObjectManager $manager)
    {
        for ($i = 1; $i <= self::NB_CATEGORIES; $i++) {
            $category = new Category();
            $category->setTitle($this->faker->sentence(1))
                     ->setDescription($this->faker->paragraph());
            $manager->persist($category);
            $this->addReference('CAT'.$i, $category);
        }
    }


    /**
     * Loads some dummy articles.
     *
     * @param ObjectManager $manager the object manager
     */
    private function loadArticles(ObjectManager $manager)
    {
        for ($j = 1; $j <= \rand(4,6); $j++) {
            /** @var Category $category */
            $category = $this->getReference('CAT'.\rand(1, self::NB_CATEGORIES));

            $article = new Article();
            $article->setTitle($this->faker->sentence(5))
                ->setImage('https://picsum.photos/255/309')
                ->setContent($this->faker->paragraph(10))
                ->setCategory($category)
                ->setCreatedAt(new \DateTime());
            $manager->persist($article);
            $this->addReference('ARTICLE'.$j, $category);
        }
    }

    /**
     * Loads some dummy articles.
     *
     * @param ObjectManager $manager the object manager
     */
    private function loadComments(ObjectManager $manager)
    {
        for ($k = 1; $k <= mt_rand(4,6); $k++) {
            /** @var Comment $comment */
            $article = $this->getReference('ARTICLE'.\rand(1,4));

            $comment = new Comment();
            $comment->setAuthor($this->faker->sentence(3))
                ->setContent($this->faker->paragraph(5))
                ->setArticle($article)
                ->setCreatedAt(new \DateTime());
            $manager->persist($comment);
        }
    }
}

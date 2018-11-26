<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');

        // Créer 3 catégories fake
        for ($i =1; $i <= 3; $i++)
        {
            $category = new Category();
            $category->setName($faker->sentence());

            $manager->persist($category);


            for ($j = 1; $j <= mt_rand(4, 6); $j++)
            {
                $article = new Article();

                //Va generer plusieurs paragraphe.
                $content = '<p>' . join($faker->paragraphs(3), '</p><p>') . '</p>';

                $article->setTitle($faker->sentence())
                    ->setContent($content)
                    ->setImage($faker->imageUrl())
                    ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                    ->setCategory($category);

                $manager->persist($article);

            }
        }
        $manager->flush();
    }
}

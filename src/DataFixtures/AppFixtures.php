<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $generator = Faker\Factory::create('fr-FR');

        for ($i=0; $i<30; $i++){
            $wish = new Wish();
            $wish -> setTitle($generator -> word());
            $wish -> setDescription($generator -> text(200));
            $wish -> setAuthor($generator -> firstName());
            $wish -> setIsPublished($generator -> boolean());
            $wish -> setDateCreated($generator -> dateTime());
            $wish -> setVote($generator -> randomFloat(2,1,10));
            $manager -> persist($wish);
        }
        $manager->flush();
    }
}

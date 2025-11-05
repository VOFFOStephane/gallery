<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Faker\Factory;

class CategoryFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $slugger = new AsciiSlugger();

        $categoryNames = [
            'Renaissance',
            'Baroque',
            'Classique',
            'Rococo',
            'Romantisme',
            'Réalisme',
            'Abstrait'
        ];

        foreach ($categoryNames as $name) {
            $category = new Category();
            $category->setName($name)
            ->setDescription($faker->sentence(10))
                ->setSlug(strtolower($slugger->slug($name)));
            $manager->persist($category);
        }


        $manager->flush();
    }
    //va me permetre de load les fixtures category spécifiquement
    //php bin/console doctrine:fixtures:load --group=Category
    public static function getGroups(): array
    {
        return ['Category'];
    }
}

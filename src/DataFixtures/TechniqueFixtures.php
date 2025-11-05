<?php

namespace App\DataFixtures;

use App\Entity\Technique;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Faker\Factory;

class TechniqueFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $techniqueNames = [
            "Peinture à l'huile",
            "Fresque",
            "Tempera",
            "Fusain",
            "Aquarelle",
            "Gouache",
            "Acrylique"
        ];

        foreach ($techniqueNames as $name) {
            $technique = new Technique();
            $technique->setName($name);
            $technique->setDescription($faker->sentence(8));
            $manager->persist($technique);
        }

        $manager->flush();
    }
    //load le fixture de techniqhe spécifiquement
    public static function getGroups(): array
    {
        return ['Technique'];
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Painting;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Category;
use App\Entity\Technique;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Cocur\Slugify\Slugify; //pour le slug
use Faker\Factory;


class PaintingFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $slugify = new Slugify();

        // Récupère toutes les catégories et techniques existantes
        $categories = $manager->getRepository(Category::class)->findAll();
        $techniques = $manager->getRepository(Technique::class)->findAll();

        if (empty($categories) || empty($techniques)) {
            throw new \Exception('Vous devez d’abord créer les fixtures pour Category et Technique.');
        }

        for ($i = 1; $i <= 20; $i++) { // On crée 20 peintures
            $painting = new Painting();
            $painting->setTitle($faker->sentence(3))
                ->setDescription($faker->paragraph())
                ->setCreated(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 years', 'now')))
                ->setEdited(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 years', 'now')))
                ->setHeight($faker->randomFloat(2, 20, 200))
                ->setWidth($faker->randomFloat(2, 20, 200))
                ->setImage("painting_$i.jpg")
                ->setIsPublished($faker->boolean(90))
                ->setCategory($faker->randomElement($categories))
                ->setTechnique($faker->randomElement($techniques))
                ->setSlug($slugify->slugify($painting->getTitle()));

            $manager->persist($painting);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            TechniqueFixtures::class,
        ];
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserFixtures extends Fixture
{
    private object $hasher;
    private array $genders = ['male', 'female'];
    /**
     * UserFixtures constructor.
     * @param UserPasswordHasherInterface $hasher
     */
    public function __construct(UserPasswordHasherInterface
                                $hasher, private readonly SluggerInterface $slugger)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 10; $i < 60; $i++) {
            $gender = $faker->randomElement($this->genders);
            $user = new User();
            $user ->setFirstName($faker->firstName($gender))
                ->setLastName($faker->lastName($gender))
                ->setEmail($this->slugger->slug($user->getFirstName($gender).'.'
                        .$this->slugger->slug($user->getLastName())).'@'.$faker->domainName());

            $gender = $gender == 'male' ? 'm' : 'f';
            $user ->setImageName('0'.$i. $gender.'.jpg')
                ->setPassword($this->hasher->hashPassword($user,'password'))
                ->setIsDesabled($faker->boolean(10))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }
        //ADMIN jOHN DOE
        $user = new User();
        $user ->setFirstName('John')
            ->setLastName('Doe')
            ->setEmail('JohnDoe@mail.com')
            ->setImageName('062m.jpg')
            ->setPassword($this->hasher->hashPassword($user,'password'))
            ->setIsDesabled(false)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);
        $manager->flush();

        //SUPER ADMIN PAT MAR
        $user = new User();
        $user ->setFirstName('Pat')
            ->setLastName('Mar')
            ->setEmail('PatMar@mail.com')
            ->setImageName('063m.jpg')
            ->setPassword($this->hasher->hashPassword($user,'password'))
            ->setIsDesabled(false)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setRoles(['ROLE_SUPER_ADMIN']);
        $manager->persist($user);
        $manager->flush();
    }
}

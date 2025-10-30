<?php
// src/DataFixtures/UserFixtures.php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->unique()->email());
            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setCreatedAt(new \DateTimeImmutable($faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s')));
            $user->setRoles(['ROLE_USER']);

            $password = $this->passwordHasher->hashPassword($user, 'password123');
            $user->setPassword($password);

            $manager->persist($user);

            // 🔗 Ajout de référence pour UserGroupFixtures
            $this->addReference('user_' . $i, $user);
        }

        $manager->flush();
    }
}

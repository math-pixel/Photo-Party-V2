<?php
// src/DataFixtures/UserGroupFixtures.php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\User;
use App\Entity\UserGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserGroupFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $roles = ['admin', 'editeur', 'membre'];

        // Exemple : chaque user est dans 2 groupes différents
        for ($i = 0; $i < 10; $i++) {
            $user = $this->getReference('user_' . $i, User::class);

            // Associer à 2 groupes différents
            $groupIndexes = $faker->randomElements(range(0, 4), 2);

            foreach ($groupIndexes as $groupIndex) {
                $group = $this->getReference('group_' . $groupIndex, Group::class);

                $userGroup = new UserGroup();
                $userGroup->setUser($user);
                $userGroup->setGroup($group);
                $userGroup->setRole($faker->randomElement($roles));
                $userGroup->setCreatedAt(new \DateTimeImmutable($faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s')));

                $manager->persist($userGroup);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            GroupFixtures::class,
        ];
    }
}

<?php
// src/DataFixtures/GroupFixtures.php

namespace App\DataFixtures;

use App\Entity\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Uid\Uuid;

class GroupFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $group = new Group();
            $group->setToken(Uuid::v4()); // Génère un token UUID v4
            $group->setName($faker->words(3, true)); // 3 mots concaténés pour le nom du groupe
            $group->setCreatedAt(\DateTimeImmutable::createFromMutable(
                $faker->dateTimeBetween('-1 year', 'now')
            ));
            $group->setUrlImage1($faker->words(3, true));
            $group->setUrlImage2($faker->words(3, true));

            $manager->persist($group);

            // 🔗 Ajouter une référence pour les utiliser dans d'autres fixtures (ex: Photo)
            $this->addReference('group_' . $i, $group);
        }

        $manager->flush();
    }
}

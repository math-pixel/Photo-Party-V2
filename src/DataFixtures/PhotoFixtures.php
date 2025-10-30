<?php
// src/DataFixtures/PhotoFixtures.php

namespace App\DataFixtures;

use App\Entity\Photo;
use App\Entity\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PhotoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Il faut que des groupes existent déjà (via GroupFixtures)
        // Par exemple : 5 groupes créés avec le code addReference("group_0" ... "group_4")
        for ($i = 0; $i < 20; $i++) {
            $photo = new Photo();
            $photo->setMedia($faker->imageUrl(640, 480, 'nature', true)); // URL d'image fake
            $photo->setCommentary($faker->optional()->sentence(6));
            $photo->setIsAllowed($faker->boolean(80)); // 80% de chances que ce soit TRUE
            $photo->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-6 months', 'now')));

            // Associer un groupe existant (généré par GroupFixtures avec addReference)
            $randomGroupIndex = $faker->numberBetween(0, 4); // ajuster selon le nombre de groupes créés
            $group = $this->getReference('group_' . $randomGroupIndex, Group::class);
            $photo->setGroupId($group);

            $manager->persist($photo);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            GroupFixtures::class,
        ];
    }
}

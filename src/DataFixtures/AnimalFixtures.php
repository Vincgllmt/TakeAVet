<?php

namespace App\DataFixtures;

use App\Factory\AnimalFactory;
use App\Factory\CategoryAnimalFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AnimalFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        AnimalFactory::createMany(25, function () {
            return ['CategoryAnimal' => CategoryAnimalFactory::random()];
        });
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}

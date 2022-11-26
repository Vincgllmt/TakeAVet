<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        UserFactory::createMany(10, function () {
            return [
                'tel' => UserFactory::faker()->boolean(50)
                    ? UserFactory::faker()->phoneNumber()
                    : null,
            ];
        });

        $manager->flush();
    }
}

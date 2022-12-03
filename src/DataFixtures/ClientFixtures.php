<?php

namespace App\DataFixtures;

use App\Factory\ClientFactory;
use App\Factory\ThreadFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ClientFactory::createMany(15, function () {
            return [
                'threads' => ThreadFactory::createMany(ClientFactory::faker()->numberBetween(0, 5)),
            ];
        });
    }
}

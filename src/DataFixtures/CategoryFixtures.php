<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $file = json_decode(file_get_contents(__DIR__.'/data/Animals.json'), flags: JSON_OBJECT_AS_ARRAY);
        foreach ($file as $category) {
            CategoryFactory::createOne($category);
        }
    }
}

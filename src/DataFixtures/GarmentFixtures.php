<?php

namespace App\DataFixtures;

use App\Factory\GarmentFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GarmentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        GarmentFactory::new()->createMany(10);
    }
}

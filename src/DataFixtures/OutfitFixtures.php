<?php

namespace App\DataFixtures;

use App\Factory\OutfitFactory;
use App\Factory\PieceFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OutfitFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        PieceFactory::createMany(20);
        // Example 5: create 3 Posts each with between 0 and 3 unique Tags
        OutfitFactory::createMany(10);
    }
}

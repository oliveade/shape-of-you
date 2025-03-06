<?php

namespace App\DataFixtures;

use App\Factory\SeasonFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       SeasonFactory::new()->createSequence(
            [
                [
                    'name' => 'spring',
                    'deleted' => false,
                ],
                [
                    'name' => 'summer',
                    'deleted' => false,
                ],
                [
                    'name' => 'autumn',
                    'deleted' => false,
                ],
                [
                    'name' => 'winter',
                    'deleted' => false,
                ],
            ]
        );
    }
}

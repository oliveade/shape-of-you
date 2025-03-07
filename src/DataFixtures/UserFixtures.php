<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::new()->isAdmin()->create([
            'username' => 'petitbiscuit',
            'email' => 'junior@resend.com',
            'deleted' => false,
        ]);

        UserFactory::new()->isAdmin()->create([
            'username' => 'sukeshi',
            'email' => 'matheo@resend.com',
            'deleted' => false,
        ]);

        UserFactory::new()->isAdmin()->create([
            'username' => 'gratias',
            'email' => 'olive@resend.com',
            'deleted' => false,
        ]);

        UserFactory::new()->createMany(30);
    }
}

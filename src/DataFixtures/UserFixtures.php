<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::new()->isAdmin()->activated()->create([
            'firstName' => 'Junior',
            'lastName' => 'Djemba',
            'email' => 'delivered@resend.com',
            'password' => 'aqwzsxedc',
        ]);

        UserFactory::new()->isAdmin()->activated()->create([
            'firstName' => 'Matheo',
            'lastName' => 'Saiter',
            'email' => 'matheo_admin@resend.com',
            'password' => 'aqwzsxedc',
        ]);

        UserFactory::new()->isAdmin()->activated()->create([
            'firstName' => 'Olive',
            'lastName' => 'Ade',
            'email' => 'olive_admin@resend.com',
            'password' => 'aqwzsxedc',
        ]);

        UserFactory::new()->activated()->createMany(5);

        UserFactory::new()->banned()->bannedAt()->createMany(5);

        UserFactory::new()->deleted()->deletedAt()->createMany(5);

        UserFactory::new()->pending()->createMany(5);
    }
}

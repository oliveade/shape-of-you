<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'email' => 'junior_admin@resend.com',
            'password' => 'aqwzsxedc',
            'roles' => [User::ROLE_ADMIN],
        ]);

        UserFactory::createOne([
            'email' => 'matheo_admin@resend.com',
            'password' => 'aqwzsxedc',
            'roles' => [User::ROLE_ADMIN],
        ]);

        UserFactory::createOne([
            'email' => 'olive_admin@resend.com',
            'password' => 'aqwzsxedc',
            'roles' => [User::ROLE_ADMIN],
        ]);

        UserFactory::createOne([
            'email' => 'jorja@symfony.com',
            'password' => 'aqwzsxedc',
            'roles' => [User::ROLE_USER],
        ]);

        UserFactory::createOne([
            'email' => 'tems@symfony.com',
            'password' => 'aqwzsxedc',
            'roles' => [User::ROLE_USER],
        ]);

        UserFactory::createOne([
            'email' => 'bibi@symfony.com',
            'password' => 'aqwzsxedc',
            'roles' => [User::ROLE_USER],
        ]);
    }
}

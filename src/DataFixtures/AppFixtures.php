<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
	
	private UserPasswordHasherInterface $passwordHasher;
	
	public function __construct(UserPasswordHasherInterface $passwordHasher)
	{
		$this->passwordHasher = $passwordHasher;
	}
	
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        
        $user = new User();
        $user->setEmail('test@example.com');
        $user->setRoles(['ROLE_ADMIN']);
		
		$hashedPassword = $this->passwordHasher->hashPassword($user, 'testing');
		$user->setPassword($hashedPassword);
		
		$user->setUsername('test_account');
		
		$user->setBirthdate(new \DateTime('1990-01-01'));
		
        $manager->persist($user);

        $manager->flush();
    }
}

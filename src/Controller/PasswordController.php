<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PasswordController extends AbstractController
{
    #[Route('/password_forgotten', name: 'app_password_forgotten')]
    public function index(): Response
    {
        // handle mail error
		
        $error = null;
		
        return $this->render('auth/password_forgotten.html.twig', [
            'controller_name' => 'PasswordController',
            'error' => $error,
        ]);
    }
	
    #[Route('/password_reset', name: 'app_password_reset')]
    public function reset(): Response
    {
        // handle error with mail reset password
		
        $error = null;
		
        return $this->render('auth/password_reset.html.twig', [
            'controller_name' => 'PasswordController',
            'error' => $error,
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('home.html.twig');
        //return $this->redirectToRoute('app_login');
    }

    // #[Route('/', name: 'app_home_page')]
    // public function home(): Response
	// {
	//     if ($this->getUser()) {
	//         return $this->redirectToRoute('app_home');
	//     }
	// }
}

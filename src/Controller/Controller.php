<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    #[Route('/addimage', name: 'app_upload_photo')]
    public function test(): Response
    {
        return $this->render('/photos.html.twig');
    }

    #[Route('/', name: 'app_index')]
    public function home(): Response
    {
        return $this->render('/index.html.twig');
    }

    #[Route('/accueil', name: 'app_home')]
    public function darshboardUser(): Response
    {
        return $this->render('/home.html.twig');
    }
}

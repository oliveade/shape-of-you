<?php

Namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    #[Route('/addimage', name: 'app_upload_photo')]
    public function test():Response
    {
        return $this->render('/photos.html.twig');
    }
    #[Route('/', name: 'test')]
    public function home():Response
    {
        return $this->render('/home.html.twig');
    }
}
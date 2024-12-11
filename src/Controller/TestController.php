<?php

Namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/admin', name: 'test')]
    public function test():Response
    {
        //return new Response('Bonjour');
        return $this->render('/admin.html.twig');
    }
}
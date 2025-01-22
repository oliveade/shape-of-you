<?php

Namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/tenueproposee', name: 'tenue_proposee')]
    public function Clothing():Response
    {
        return $this->render('/home.html.twig');
    }
    #[Route('/search', name: 'recherche_tenue')]
    public function Search():Response
    {
        return $this->render('/home.html.twig');
    }
    #[Route('/partenaires', name: 'sites_partenaires')]
    public function Partenaires():Response
    {
        return $this->render('/home.html.twig');
    }
    #[Route('/partenaires', name: 'historique_tenues')]
    public function Historique():Response
    {
        return $this->render('/home.html.twig');
    }
    #[Route('/social', name: 'onglet_social')]
    public function Social():Response
    {
        return $this->render('/home.html.twig');
    }
   
}
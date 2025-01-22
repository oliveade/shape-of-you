<?php

namespace App\Controller;

use App\Service\ContentApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    private $contentApiService;

    public function __construct(ContentApiService $contentApiService)
    {
        $this->contentApiService = $contentApiService;
    }

    #[Route('/shop',name:'shop')]
    public function shop(): Response
    {
        $query = 'vêtements';
        try {
            $items = $this->contentApiService->getItems($query);
            dd($items);
        } catch (\Exception $e) {
            return new Response('Erreur lors de la récupération des articles : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->render('shop/index.html.twig', [
            'items' => $items,
        ]);
    }

    #[Route('/redirect/{id}', name:'redirect_item')]
    public function redirectToPartner($id): Response
    {
        $partnerUrl = 'https://www.partenaire.com/produit/' . $id;
        return $this->redirect($partnerUrl);
    }
}

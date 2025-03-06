<?php

namespace App\Controller;

use App\Entity\Garment;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\OpenAIService;
use Symfony\Component\Routing\Annotation\Route;

class GarmentController extends AbstractController
{
    #[Route('/add-garment', name: 'add-garment', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $garment = new Garment();
            $garment->setName($request->request->get('name'));
            $garment->setType($request->request->get('type'));
            $garment->setColor($request->request->get('color'));
            $garment->setStyle($request->request->get('style'));
            $garment->setSeason($request->request->get('season'));
            $garment->setMaterial($request->request->get('material'));
            $garment->setOccasion($request->request->get('occasion'));
            $garment->setShared($request->request->getBoolean('isShared', false));
            $imageFile = $request->files->get('imageUrl');
            if ($imageFile) {
                $fileName = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move($this->getParameter('uploads_directory'), $fileName);
                $garment->setImageUrl($fileName);
            }

            // $user = $this->getUser();
            // if (!$user) {
            //     $this->addFlash('error', 'Vous devez être connecté pour ajouter un vêtement.');
            //     return $this->redirectToRoute('app_login'); 
            // }

            $user = $em->getRepository(User::class)->find(1);
            $garment->setUsers($user);
            $em->persist($garment);
            $em->flush();
            $this->addFlash('success', 'Vêtement ajouté avec succès !');
            return $this->redirectToRoute('my_wardrobe');
        }

        return $this->render('add_garment.html.twig');
    }
 
    #[Route('/garment', name: 'user-add-garment')]
    public function Garment(): Response
    {
        return $this->render('/garment/add.html.twig');
    }

    #[Route('/my_wardrobe', name: 'my_wardrobe')]
    public function Wardrobe(EntityManagerInterface $em): Response
    {
        $garments = $em->getRepository(Garment::class)->findAll();
       
        return $this->render('wardrobe.html.twig', [
            'garments' => $garments
        ]);
    }
    #[Route('/garment/delete/{id}', name: 'garment_delete', methods: ['POST'])]
    public function deleteGarment(Garment $garment, EntityManagerInterface $em): Response
    {
        // $user = $this->getUser();
        $user = $em->getRepository(User::class)->find(1);
        if ($garment->getUsers() !== $user) {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer ce vêtement.');
            return $this->redirectToRoute('my_wardrobe');
        }
        $em->remove($garment);
        $em->flush();
        $this->addFlash('success', 'Vêtement supprimé avec succès.');
        return $this->redirectToRoute('my_wardrobe');
    }

    #[Route('/recommend-outfit', name: 'recommend_outfit')]
    public function recommendOutfit(EntityManagerInterface $em, OpenAIService $openAIService): Response
    {

        $user = $em->getRepository(User::class)->find(1);
        $garments = $em->getRepository(Garment::class)->findBy(['users' => $user]);
        if (count($garments) < 2) {

            $this->addFlash('error', 'Ajoutez plus de vêtements.');
            return $this->redirectToRoute('my_wardrobe');
        }
        $suggestedGarmentsData = $openAIService->generateOutfitSuggestion($garments);
        $selectedGarments = [];
        foreach ($suggestedGarmentsData as $item) {
            $garment = $em->getRepository(Garment::class)->findOneBy([
                'type' => $item['type'],
                'color' => $item['color'],
                'style' => $item['style'],
                'users' => $user
            ]);
            if ($garment) {
                $selectedGarments[] = $garment;
            }
        }

        $imageUrl = $openAIService->generateOutfitImage($selectedGarments);
        return $this->render('/garment/recommendation.html.twig', [
            'selectedGarments' => $selectedGarments,
            'imageUrl' => $imageUrl
        ]);
    }
    #[Route('/garment/search', name: 'garment_search', methods: ['GET'])]
    public function searchGarment(Request $request, EntityManagerInterface $em): Response
    {
        $query = $request->query->get('search');
        // $user = $this->getUser();
        $user = $em->getRepository(User::class)->find(1);
        $garments = $em->getRepository(Garment::class)->createQueryBuilder('g')
            ->where('g.users = :user')
            ->andWhere('g.name LIKE :query OR g.type LIKE :query OR g.color LIKE :query OR g.style LIKE :query')
            ->setParameter('user', $user)
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();

        return $this->render('/wardrobe.html.twig', [
            'garments' => $garments
        ]);
    }
}

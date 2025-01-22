<?php
namespace App\Controller;

use App\Entity\Garment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

            $imageFile = $request->files->get('imageUrl');
            if ($imageFile) {
                $fileName = uniqid().'.'.$imageFile->guessExtension();
                $imageFile->move($this->getParameter('/public/uploads'), $fileName);
                $garment->setImageUrl($fileName);
            }
            $garment->setUsers($this->getUser());

            $em->persist($garment);
            $em->flush();

            return $this->redirectToRoute('my_wardrobe');
        }

        return $this->render('home.html.twig');
    }

    #[Route('/garment', name: 'user-add-garment')]
    public function Garment():Response
    {
        return $this->render('/garment/add.html.twig');
    }
}

<?php

namespace App\Controller;

use App\Service\GoogleVisionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ImageController extends AbstractController
{
    #[Route('/upload', name: 'image', methods: ['POST'])]
    public function upload(Request $request, GoogleVisionService $visionService): Response
    {
        $fileupload = $request->files->get('image');
        
        if (!$fileupload) {
            return new JsonResponse(['error' => 'Aucun fichier reçu'], 400);
        }
        $uploadDir = $this->getParameter('kernel.project_dir').'/public/uploads/';
        $fileName = uniqid().'.'.$fileupload->guessExtension();

        try {
            $fileupload->move($uploadDir, $fileName);
        } catch (FileException $e) {
            return new JsonResponse(['error' => 'Erreur lors de l\'upload'], 500);
        }

        $imagePath = $uploadDir.$fileName;
        $results = $visionService->analyzeImage($imagePath);

        if (isset($results['error'])) {
            return new JsonResponse(['error' => $results['error']], 500);
        }

        $formattedResults = [];
        foreach ($results as $object) {
            $name = $object['name'];
            $confidence = round($object['confidence'] * 100, 2);
            $vertices = $object['vertices'];

            $formattedResults[] = [
                'name' => $name,
                'confidence' => $confidence,
                'vertices' => $vertices,
            ];
        }

        return $this->render('/upload_result.html.twig', [
            'objects' => $formattedResults,
        ]);
    }
}

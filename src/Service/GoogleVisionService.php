<?php

namespace App\Service;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;


class GoogleVisionService
{
    private ImageAnnotatorClient $imageAnnotator;

    public function __construct(string $credentialsPath)
    {
        putenv("GOOGLE_APPLICATION_CREDENTIALS=$credentialsPath");
    
        $this->imageAnnotator = new ImageAnnotatorClient();
    }

    public function analyzeImage(string $imagePath): array
    {
        $image = file_get_contents($imagePath);
        $response = $this->imageAnnotator->objectLocalization($image);
        $objects = $response->getLocalizedObjectAnnotations();

        $results = [];
        foreach ($objects as $object) {
            $results[] = [
                'name' => $object->getName(),
                'confidence' => $object->getScore(),
                'vertices' => array_map(function ($vertex) {
                    return ['x' => $vertex->getX(), 'y' => $vertex->getY()];
                }, iterator_to_array($object->getBoundingPoly()->getNormalizedVertices()))
            ];
        }

        $this->imageAnnotator->close();
        return $results;
    }
}

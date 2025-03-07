<?php

namespace App\Service;

use Google\Cloud\Vision\V1\AnnotateImageRequest;
use Google\Cloud\Vision\V1\BatchAnnotateImagesRequest;
use Google\Cloud\Vision\V1\Client\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Feature\Type;
use Google\Cloud\Vision\V1\Image;

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
        $imageData = file_get_contents($imagePath);
        $image = (new Image())->setContent($imageData);

        $feature = (new Feature())->setType(Type::OBJECT_LOCALIZATION);
        $request = (new AnnotateImageRequest())
            ->setImage($image)
            ->setFeatures([$feature]);

        $batchRequest = (new BatchAnnotateImagesRequest())->setRequests([$request]);

        $response = $this->imageAnnotator->batchAnnotateImages($batchRequest);
        $responses = $response->getResponses();
        if (empty($responses) || $responses[0]->hasError()) {
            return [];
        }

        $localizedObjects = $responses[0]->getLocalizedObjectAnnotations();
        $results = [];

        foreach ($localizedObjects as $object) {
            $results[] = [
                'name' => $object->getName(),
                'confidence' => $object->getScore(),
                'vertices' => array_map(fn ($vertex) => ['x' => $vertex->getX(), 'y' => $vertex->getY()],
                    iterator_to_array($object->getBoundingPoly()->getNormalizedVertices())),
            ];
        }

        $this->imageAnnotator->close();

        return $results;
    }
}

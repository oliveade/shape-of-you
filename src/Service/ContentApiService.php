<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ContentApiService
{
    private $httpClient;
    private $apiKey;

    public function __construct(HttpClientInterface $httpClient, string $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
    }

    public function getItems($query)
    {
        $response = $this->httpClient->request('GET', 'https://content.googleapis.com/content/v2.1/products', [
            'query' => [
                'key' => $this->apiKey,
                'query' => $query,
            ],
        ]);

        if ($response->getStatusCode() === 200) {
            return $response->toArray();
        }

        throw new \Exception('Erreur lors de l\'appel à l\'API : ' . $response->getStatusCode());
    }
}

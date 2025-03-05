<?php

namespace App\Service;

use OpenAI;

class OpenAIService
{
    private $client;

    public function __construct(string $openAiApiKey)
    {
        $this->client = OpenAI::client($openAiApiKey);
    }

    public function generateOutfitSuggestion(array $garments): array
    {
        $garmentDescriptions = array_map(fn($g) => "{$g->getType()} {$g->getColor()} style {$g->getStyle()}", $garments);

        $prompt = "L'utilisateur possède ces vêtements : " . implode(", ", $garmentDescriptions) .
            ". Propose une tenue complète et cohérente sous forme JSON : [{\"name\": \"nom\", \"type\": \"type\", \"color\": \"couleur\", \"style\": \"style\"}].";

        // Utiliser l'endpoint pour le modèle de chat
        $response = $this->client->chat()->create([
            'model' => 'gpt-3.5-turbo', // ou 'gpt-4' si disponible pour ton compte
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt,
                ],
            ],
            'max_tokens' => 200,
        ]);

        $responseText = $response['choices'][0]['message']['content'];

        return json_decode($responseText, true) ?: [];
    }

    public function generateOutfitImage(array $garments): string
    {
        $garmentDescriptions = array_map(fn($g) => "{$g->getType()} {$g->getColor()} style {$g->getStyle()}", $garments);

        $prompt = "Illustration réaliste d'une tenue complète composée de : " . implode(", ", $garmentDescriptions) .
            ". Le rendu doit être esthétique et stylé.";

        $response = $this->client->images()->create([
            'model' => 'dall-e-3',
            'prompt' => $prompt,
            'n' => 1,
            'size' => '1024x1024'
        ]);

        return $response['data'][0]['url'] ?? '';
    }
}

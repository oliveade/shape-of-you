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

        $response = $this->client->completions()->create([
            'model' => 'gpt-4',
            'prompt' => $prompt,
            'max_tokens' => 200,
        ]);

        return json_decode($response['choices'][0]['text'], true) ?: [];
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

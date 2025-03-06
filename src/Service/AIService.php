<?php

namespace App\Services;

use App\Repository\OutfitRepository;

class AIService
{
    public function __construct(private readonly OutfitRepository $outfitRepository)
    {
    }

    // L'IA détecte automatiquement les différents éléments d'une photo.
    public function detect()
    {
    }

    // L'IA propose des tenues basées sur les tenues de l’utilisateur ou à partir de sa garde robe.
    public function suggest()
    {
        $this->outfitRepository->findBy(['public' => true], ['createdAt' => 'ASC'], 5, 3);
    }
}

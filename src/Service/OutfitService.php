<?php

namespace App\Service;

use App\Repository\OutfitRepository;

class OutfitService
{
    public function __construct(private readonly OutfitRepository $outfitRepository)
    {
    }

    // Voir les tenues partagés par les autres utilisateurs
    public function getFeed()
    {
        $this->outfitRepository->findBy(['public' => true], ['createdAt' => 'ASC'], 5, 3);
    }
}

<?php

namespace App\Services;

use App\Repository\OutfitRepository;

class SocialService
{
    public function __construct(private readonly OutfitRepository $outfitRepository)
    {
    }

    // Voir les tenues partagés par les autres utilisateurs
    public function getFeed()
    {
        $this->outfitRepository->findBy(['public' => true], ['createdAt' => 'ASC'], 5, 3);
    }

    // Voir toutes les tenue partagés par un autres utilisateur
    public function getUserOutfits()
    {
        $this->outfitRepository->findBy(['public' => true], ['createdAt' => 'ASC'], 5, 3);
    }

    // Voir une tenue partagés par un autres utilisateur
    public function getOneOutfit()
    {
        $this->outfitRepository->findBy(['public' => true], ['createdAt' => 'ASC'], 5, 3);
    }
}

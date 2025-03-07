<?php

namespace App\Entity;

use App\Repository\OutfitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OutfitRepository::class)]
class Outfit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
	
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_creation = null;
	
    #[ORM\Column]
    private ?bool $public = null;
	
    public function getId(): ?int
    {
        return $this->id;
    }
	
    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }
	
    public function setDateCreation(\DateTimeInterface $date_creation): static
    {
        $this->date_creation = $date_creation;
		
        return $this;
    }
	
    public function isPublic(): ?bool
    {
        return $this->public;
    }
	
    public function setPublic(bool $public): static
    {
        $this->public = $public;
		
        return $this;
    }
}

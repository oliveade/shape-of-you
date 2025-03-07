<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    final public const ROLE_USER = 'ROLE_USER';
    final public const ROLE_ADMIN = 'ROLE_ADMIN';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $username = null;
	
    #[ORM\Column(type: Types::STRING, unique: true)]
    private ?string $email = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column(type: Types::STRING)]
    private ?string $password = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthdate = null;
	
    /**
     * @var string[] The user roles
     */
    #[ORM\Column(type: Types::JSON)]
    private array $roles = [];
	
    /**
     * @var Collection<int, Garment>
     */
    #[ORM\OneToMany(targetEntity: Garment::class, mappedBy: 'users')]
    private Collection $garments;

    #[ORM\Column]
    private ?bool $deleted = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $createdBy = null;

    #[ORM\Column]
    #[Timestampable(on: 'create')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Timestampable(on: 'update')]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;
	
    public function __construct()
    {
        $this->garments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }
	
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * @return list<string>
     *
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        if (empty($roles)) {
            $roles[] = self::ROLE_USER;
        }

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        
        return $this;
    }

    /**
     * @return Collection<int, Garment>
     */
    public function getGarments(): Collection
    {
        return $this->garments;
    }

    public function addGarment(Garment $garment): static
    {
        if (!$this->garments->contains($garment)) {
            $this->garments->add($garment);
            $garment->setUsers($this);
        }

        return $this;
    }

    public function removeGarment(Garment $garment): static
    {
        if ($this->garments->removeElement($garment)) {
            if ($garment->getUsers() === $this) {
                $garment->setUsers(null);
            }
        }
		
        // j'ai une erreur ici mon ide me dit qu'il manque un return
        // je l'ai ajouté pour régler le pb mais ça peut être supp si besoin
        return $this;
    }

    public function isDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): static
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?string $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}

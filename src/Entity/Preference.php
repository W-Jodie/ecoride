<?php

namespace App\Entity;

use App\Repository\PreferenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreferenceRepository::class)]
class Preference
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'preference', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?bool $isSmoking = null;

    #[ORM\Column]
    private ?bool $isAnimals = null;

    #[ORM\Column(length: 255)]
    private ?string $extra = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function isSmoking(): ?bool
    {
        return $this->isSmoking;
    }

    public function setIsSmoking(bool $isSmoking): static
    {
        $this->isSmoking = $isSmoking;

        return $this;
    }

    public function isAnimals(): ?bool
    {
        return $this->isAnimals;
    }

    public function setIsAnimals(bool $isAnimals): static
    {
        $this->isAnimals = $isAnimals;

        return $this;
    }

    public function getExtra(): ?string
    {
        return $this->extra;
    }

    public function setExtra(string $extra): static
    {
        $this->extra = $extra;

        return $this;
    }
}

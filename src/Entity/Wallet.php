<?php

namespace App\Entity;

use App\Repository\WalletRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WalletRepository::class)]
class Wallet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'wallet', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['carpooling:read','user:read'])]
    private ?float $credit = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['carpooling:read','user:read'])]
    private ?float $pendingCredit = null;

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

    public function getCredit(): ?float
    {
        return $this->credit;
    }

    public function setCredit(?float $credit): static
    {
        $this->credit = $credit;

        return $this;
    }

    public function getPendingCredit(): ?float
    {
        return $this->pendingCredit;
    }

    public function setPendingCredit(?float $pendingCredit): static
    {
        $this->pendingCredit = $pendingCredit;

        return $this;
    }
}

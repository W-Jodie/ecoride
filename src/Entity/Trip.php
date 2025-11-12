<?php

namespace App\Entity;

use App\Repository\TripRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TripRepository::class)]
class Trip
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['trip:read'])]
    private ?string $driverName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['trip:read'])]
    private ?string $departure = null;

    #[ORM\Column(length: 255)]
    #[Groups(['trip:read'])]
    private ?string $arrival = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['trip:read'])]
    private ?\DateTimeInterface $departureDate = null;

    #[ORM\Column(type: 'integer')]
    #[Groups(['trip:read'])]
    private ?int $availableSeats = null;
}

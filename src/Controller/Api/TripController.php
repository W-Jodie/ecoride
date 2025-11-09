<?php

namespace App\Controller\Api;

use App\Repository\TripRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/trips', name: 'api_trips_')]
class TripController extends AbstractController
{
    #[Route('', name: 'list', methods: ['GET'])]
    public function list(TripRepository $tripRepository, SerializerInterface $serializer): JsonResponse
    {
        $trips = $tripRepository->findAll();

        $json = $serializer->serialize($trips, 'json', ['groups' => ['trip:read']]);

        return new JsonResponse($json, 200, [], true);
    }
}

<?php

namespace App\Controller\Api\Profile;

use App\Repository\CarpoolingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TripController extends AbstractController
{
    #[Route('/api/profile/trip', name: 'app_api_profile_trip')]
        public function index(CarpoolingRepository $tripRepository): Response
        {
            // TEST RAPIDE — user ID 1
            $user = 22;

            $trips = $tripRepository->findBy(['driver' => $user]);

            if (!$trips) {
                return $this->json(['message' => 'Aucun trajet en cours'], 200);
            }

            return $this->json($trips, 200, [], ['groups' => 'trip:read']);
        }

}

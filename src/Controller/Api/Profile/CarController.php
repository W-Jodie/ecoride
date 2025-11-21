<?php

namespace App\Controller\Api\Profile;

use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CarController extends AbstractController
{
    #[Route('/api/profile/car', name: 'app_api_profile_car', methods: ['GET'])]
    public function index(CarRepository $carRepository): Response
    { 
        // 1. Vérifier si l'utilisateur est authentifié
        $user = 1;
        if (!$user) {
            return $this->json(['message' => 'Unauthorized'], 401);
        }

        // 2. Récupérer la voiture liée à cet utilisateur (clé correcte = owner)
        $car = $carRepository->findBy(['owner' => $user]);

        // 3. Vérifier que l'utilisateur possède bien une voiture
        if (!$car) {
            return $this->json(['message' => 'Aucune voiture trouvée pour cet utilisateur'], 404);
        }

        // 4. Retourner la voiture avec le groupe de serialization 'car:read'
        return $this->json($car, 200, [], ['groups' => 'car:read']);
    }
}

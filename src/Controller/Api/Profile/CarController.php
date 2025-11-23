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
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['message' => 'Unauthorized'], 401);
        }

        $car = $carRepository->findBy(['owner' => $user, 'isActive' => true]);

        if (!$car) {
            return $this->json(['message' => 'Aucune voiture trouvée pour cet utilisateur'], 200);
        }

         $currentRoles = $user->getRoles();
      if (in_array('ROLE_DRIVER', $currentRoles)) {
        return $this->json($car, 200, [], ['groups' => 'car:read']);

            
        } else {
        return $this->json('Voitures indispo', 200, [], ['groups' => 'car:read']);

           
        }

    }
    
}

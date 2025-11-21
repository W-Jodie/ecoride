<?php

namespace App\Controller\Api\Car;

use App\Entity\Car;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class AddCarController extends AbstractController
{
    #[Route('/api/car', name: 'api_car_add', methods: ['POST'])]
    public function addCar(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $user = $this->getUser();
        // Décoder le JSON reçu
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(['error' => 'JSON invalide'], 400);
        }

        // Vérifier les champs obligatoires
        foreach (['brand', 'model', 'licensePlate', 'isElectric'] as $field) {
            if (!isset($data[$field])) {
                return new JsonResponse(['error' => "Le champ '$field' est manquant"], 400);
            }
        }

        

        // Création de la voiture
        $car = new Car();
        $car->setBrand($data['brand']);
        $car->setModel($data['model']);
        $car->setLicensePlate($data['licensePlate']);
        $car->setOwner($user);
        $car->setIsElectric((bool)$data['isElectric']);

        // Sauvegarde en base
        $em->persist($car);
        $em->flush();

        return new JsonResponse([
            'success' => true,
            'message' => 'Voiture créée avec succès',
            'carId' => $car->getId()
        ], 201);
    }
}

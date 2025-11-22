<?php

namespace App\Controller\Api\Carpooling;

use App\Entity\Car;
use App\Entity\Carpooling;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CrudCarpoolingController extends AbstractController
{
    #[Route('/api/carpooling', name: 'api_trip_add', methods: ['POST'])]
    public function addTrip(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $user = $this->getUser();

        if (!$user) {
            return new JsonResponse(['error' => 'Utilisateur non connecté'], 401);
        }

        // Décoder JSON
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(['error' => 'JSON invalide'], 400);
        }

        // Champs obligatoires
        $required = ['departure', 'arrival', 'date', 'time', 'seats', 'price', 'carId'];
        foreach ($required as $field) {
            if (!isset($data[$field]) || $data[$field] === "") {
                return new JsonResponse(['error' => "Le champ '$field' est manquant"], 400);
            }
        }

        // Récupération de la voiture
        $car = $em->getRepository(Car::class)->find($data['carId']);

        if (!$car) {
            return new JsonResponse(['error' => 'Voiture introuvable'], 404);
        }

        if ($car->getOwner() !== $user) {
            return new JsonResponse(['error' => 'Vous ne pouvez utiliser que vos propres véhicules'], 403);
        }

        // Construction DateTimeImmutable
        try {
            $departureAt = new \DateTimeImmutable($data['date'] . ' ' . $data['time']);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Date ou heure invalide'], 400);
        }

        // -------------------------------------------------------
        // 📌 Création du trajet
        // -------------------------------------------------------
        $trip = new Carpooling();
        $trip->setDeparture($data['departure']);
        $trip->setArrival($data['arrival']);
        $trip->setSeats((int)$data['seats']);
        $trip->setPrice((float)$data['price']);
        $trip->setDepartureAt($departureAt);

        // Option : durée estimée = +1h
        $trip->setArrivalAt($departureAt->modify('+1 hour'));

        $trip->setDriver($user);
        $trip->setCar($car);

        $trip->setStatus('active');     // statut par défaut
        $trip->setIsEcoTrip(false);     // ou true si tu veux l'activer plus tard

        $em->persist($trip);
        $em->flush();

        return new JsonResponse([
            'success' => true,
            'message' => 'Trajet créé avec succès',
            'tripId' => $trip->getId()
        ], 201);
    }

    #[Route('/api/car', name: 'api_car_list', methods: ['GET'])]
    public function listCars(EntityManagerInterface $em): JsonResponse
    {
        $user = $this->getUser();

        if (!$user) {
            return new JsonResponse(['error' => 'Non connecté'], 401);
        }

        $cars = $em->getRepository(Car::class)->findBy(['owner' => $user, 'isActive' => true]);

        $data = [];
        foreach ($cars as $car) {
            $data[] = [
                'id' => $car->getId(),
                'brand' => $car->getBrand(),
                'model' => $car->getModel(),
                'licensePlate' => $car->getLicensePlate(),
            ];
        }

        return new JsonResponse($data);
    }


}


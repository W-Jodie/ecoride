<?php

namespace App\Controller\Pages\Profile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CarRepository;
use App\Repository\TripRepository;
use App\Repository\WalletRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(
        CarRepository $carRepository, 
        // TripRepository $tripRepository, 
        WalletRepository $walletRepository
    ): Response {
        $user = $this->getUser();

        // Récupération des voitures de l'utilisateur
        $cars = $carRepository->findBy(['owner' => $user]);

        // Récupération des trajets de l'utilisateur
        // $trips = $tripRepository->findBy(['driver' => $user]);

        // Récupération du wallet
        $wallet = $walletRepository->findOneBy(['user' => $user]);

        return $this->render('pages/profile/index.html.twig', [
            'user' => $user,
            'cars' => $cars,
            // 'trips' => $trips,
            'wallet' => $wallet,
        ]);
    }
}

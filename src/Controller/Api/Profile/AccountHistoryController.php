<?php

namespace App\Controller\Api\Profile;

use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccountHistoryController extends AbstractController
{
    #[Route('/api/profile/account/history', name: 'app_api_profile_account_history')]
        public function index(ReservationRepository $accountRepository): Response
            {
                $user = $this->getUser();
                $reservation = $accountRepository->findBy(['driver' => $user]);

                if (!$reservation) {
                    return $this->json(['message' => 'Aucun historique trouvé'], 404);
                }

                return $this->json($reservation, 200, [], ['groups' => 'account:read']);
            }  

}


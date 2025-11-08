<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\WalletRepository;

final class UserBalanceController extends AbstractController
{
    #[Route('/api/user/balance', name: 'app_api_user_balance')]
    public function index(WalletRepository $wallets): Response
    {
        $user = $this->getUser();
        $wallet = $wallets->findOneBy(['user' => $user]) ;
        $walletData = [
            'credit' => $wallet->getCredit(),
            // 'pendingCredit' => $wallet->getPendingCredit(),
        ];
        return $this->json($walletData, 200, [], []);
    }
}

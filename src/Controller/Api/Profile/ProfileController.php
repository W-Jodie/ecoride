<?php

namespace App\Controller\Api\Profile;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProfileController extends AbstractController
{
    #[Route('/api/profile', name: 'app_api_profile', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
                $user = $this->getUser();
                if (!$user) {
                return $this->json(['message' => 'No user found'], 404);
        }

        $userProfile = $userRepository->find($user);

        return $this->json($userProfile, 200, [], ['groups' => 'user:read']);
    }
}

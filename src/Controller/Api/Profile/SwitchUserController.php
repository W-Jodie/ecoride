<?php

namespace App\Controller\Api\Profile;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SwitchUserController extends AbstractController
{
    #[Route('/api/profile/switch/role', name: 'app_api_profile_switch_role', methods: ['POST'])]
    public function switchUser(
        UserRepository $userRepository, 
        EntityManagerInterface $em
    ): Response {
        
        $user = $this->getUser();

        if (!$user) {
            return $this->json(['message' => 'No user found'], 404);
        }

        /** @var User $user */
        $currentRoles = $user->getRoles();

        // -----------------------------------------------------------
        // LOGIQUE DU TOGGLE
        // -----------------------------------------------------------
        if (in_array('ROLE_DRIVER', $currentRoles)) {
            // REVERSER → il devient PASSENGER
            $user->setRoles(['ROLE_PASSENGER']);
            $newRole = 'ROLE_PASSENGER';
        } else {
            // Sinon → il devient DRIVER
            $user->setRoles(['ROLE_DRIVER']);
            $newRole = 'ROLE_DRIVER';
        }

        $em->persist($user);
        $em->flush();

        return $this->json([
            'message' => 'Role updated successfully',
            'newRole' => $newRole
        ], 200);
    }
}

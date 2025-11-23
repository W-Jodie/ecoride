<?php

namespace App\Controller\Api\Profile;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

final class SwitchUserController extends AbstractController
{
    #[Route('/api/profile/switch/role', name: 'app_api_profile_switch_role', methods: ['POST'])]
    public function switchUser(
        Request $request,
        EntityManagerInterface $em
    ): Response {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user) {
            return $this->json(['message' => 'No user found'], 404);
        }

        $currentRoles = $user->getRoles();
        $newRole = null;

        // -----------------------------------------------------------
        // 🔄 TOGGLE ENTRE ROLE_DRIVER ET ROLE_PASSENGER
        // -----------------------------------------------------------
        if (in_array('ROLE_DRIVER', $currentRoles)) {
            $user->setRoles(['ROLE_PASSENGER']);
            $newRole = 'ROLE_PASSENGER';
        } else {
            $user->setRoles(['ROLE_DRIVER']);
            $newRole = 'ROLE_DRIVER';
        }

        // -----------------------------------------------------------
        // 💾 Sauvegarde
        // -----------------------------------------------------------
        $em->flush();

        // -----------------------------------------------------------
        // 🔐 REFRESH DE LA SESSION POUR ÉVITER LA DÉCONNEXION
        // -----------------------------------------------------------
        $token = new UsernamePasswordToken($user, 'main', $user->getRoles());
        $this->container->get('security.token_storage')->setToken($token);
        $request->getSession()->set('_security_main', serialize($token));

        // -----------------------------------------------------------
        // 🟢 RÉPONSE JSON
        // -----------------------------------------------------------
        return $this->json([
            'message' => 'Role updated successfully',
            'newRole' => $newRole,
            'roles'   => $user->getRoles()
        ], 200);
    }

    #[Route('/api/profile/role', name: 'api_profile_role', methods: ['GET'])]
public function getRole(): Response
{
    $user = $this->getUser();

    if (!$user) {
        return $this->json(['role' => null]);
    }

    return $this->json([
        'roles' => $user->getRoles()
    ]);
}

}

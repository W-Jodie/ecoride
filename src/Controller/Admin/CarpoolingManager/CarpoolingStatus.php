<?php

namespace App\Controller\Admin\CarpoolingManager;

use App\Entity\Carpooling;
use App\Repository\CarpoolingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/carpooling/manager')]
final class CarpoolingStatus extends AbstractController
{
    #[Route('/', name: 'app_admin_carpooling_status', methods: ['GET'])]
    public function index(CarpoolingRepository $carpooling): Response
    {
        $carpoolings = $carpooling->findBy(['status' => 'En attente']);

        return $this->render('admin/carpooling/carpooling_status.html.twig', [
            'carpoolings' => $carpoolings,
        ]);
    }

    #[Route('/active/{id}', name: 'app_admin_active_carpooling', methods: ['POST', 'GET'])]
    public function active(Carpooling $carpooling, EntityManagerInterface $em): Response
    {
        // 🚨 Vérifie si l'objet existe
        if (!$carpooling) {
            $this->addFlash('danger', 'Trajet introuvable.');
            return $this->redirectToRoute('app_admin_carpooling_status');
        }

        // 🚨 Vérifie le statut avant modification
        if ($carpooling->getStatus() !== 'En attente') {
            $this->addFlash('warning', 'Ce trajet est déjà traité.');
            return $this->redirectToRoute('app_admin_carpooling_status');
        }

        $carpooling->setStatus('Active');
        $em->flush(); // pas besoin de persist, il est déjà géré

        $this->addFlash('success', 'Le trajet a bien été activé.');

        return $this->redirectToRoute('app_admin_carpooling_status');
    }

     #[Route('/refuse/{id}', name: 'app_admin_refuse_carpooling', methods: ['POST', 'GET'])]
    public function refuse(Carpooling $carpooling, EntityManagerInterface $em): Response
    {
        // 🚨 Vérifie si l'objet existe
        if (!$carpooling) {
            $this->addFlash('danger', 'Trajet introuvable.');
            return $this->redirectToRoute('app_admin_carpooling_status');
        }

        // 🚨 Vérifie le statut avant modification
        if ($carpooling->getStatus() !== 'En attente') {
            $this->addFlash('warning', 'Ce trajet est déjà traité.');
            return $this->redirectToRoute('app_admin_carpooling_status');
        }

        $carpooling->setStatus('Refuse');
        $em->flush(); // pas besoin de persist, il est déjà géré

        $this->addFlash('success', 'Le trajet a bien été refusé.');

        return $this->redirectToRoute('app_admin_carpooling_status');
    }
}

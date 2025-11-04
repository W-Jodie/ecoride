<?php

namespace App\Controller\Front\Carpooling;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CapoolingController extends AbstractController
{
    #[Route('/front/carpooling', name: 'app_front_carpooling')]
    public function index(): Response
    {
        return $this->render('front/carpooling/index.html.twig', [
            'controller_name' => 'CarpoolingController',
        ]);
    }
}

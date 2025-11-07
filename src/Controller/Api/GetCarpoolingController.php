<?php

namespace App\Controller\Api;

use App\Repository\CarpoolingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GetCarpoolingController extends AbstractController
{
    #[Route('/api/get/carpooling', name: 'app_api_get_carpooling')]
    public function index(CarpoolingRepository $carpooling): Response
    {
        $carpoolings = $carpooling->findAll();
        dd($carpoolings);

        
        

      
        
    }
}

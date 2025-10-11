<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/home/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/admin/charts', name: 'admin_charts')]
    public function charts(): Response
    {
        return $this->render('admin/pages/charts.html.twig');
    }

    #[Route('/admin/buttons', name: 'admin_buttons')]
    public function buttons(): Response
    {
        return $this->render('admin/buttons.html.twig');
    }

    #[Route('/admin/tables', name: 'admin_tables')]
    public function tables(): Response
    {
        return $this->render('admin/page/tables.html.twig');
    }
}

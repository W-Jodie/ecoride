<?php

namespace App\Controller\Front\Carpooling;

use App\Repository\CarpoolingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class CapoolingController extends AbstractController
{
    #[Route('/front/carpooling', name: 'app_front_carpooling')]
    public function index(CarpoolingRepository $repo): Response
    {
        // Affiche tous les trajets (Fixtures)
        $trajets = $repo->findAll();

        return $this->render('front/carpooling/index.html.twig', [
            'trajets' => $trajets
        ]);
    }

    #[Route('/front/carpooling/search', name: 'carpooling_search', methods: ['GET'])]
    public function search(Request $request, CarpoolingRepository $repo): Response
    {
        // Récupération des valeurs du formulaire
        $depart  = $request->query->get('depart');
        $arrivee = $request->query->get('arrivee');
        $date    = $request->query->get('date');
        $prixMax = $request->query->get('prixMax');
        $eco     = $request->query->get('eco');   // "1" si coché, null sinon

        // Recherche via le Repository
        $trajets = $repo->searchCarpoolings($depart, $arrivee, $date, $prixMax, $eco);

        return $this->render('front/carpooling/index.html.twig', [
            'trajets' => $trajets,
            'depart'  => $depart,
            'arrivee' => $arrivee,
            'date'    => $date,
            'prixMax' => $prixMax,
            'eco'     => $eco,
        ]);
    }

  #[Route('/front/carpooling/{id}', name: 'app_front_carpooling_show', requirements: ['id' => '\d+'])]
public function show(int $id, CarpoolingRepository $repo): Response
{
    // On récupère le trajet demandé
    $trajet = $repo->find($id);

    // Si aucun trajet trouvé → 404
    if (!$trajet) {
        throw $this->createNotFoundException("Ce trajet n'existe pas.");
    }

    // On envoie le trajet au template
    return $this->render('front/carpooling/show.html.twig', [
        'trajet' => $trajet
    ]);
}
}

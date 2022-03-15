<?php

namespace App\Controller;

use App\Repository\ScooterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScootersController extends AbstractController
{
    #[Route('/scooters', name: 'app_scooters')]
    public function all(Request $request, ScooterRepository $repository): Response
    {
        $limit = $request->query->get('limit', 2);
        $offset = $request->query->get('offset', 0);

        //$scooters = $repository->findAll();
        $scooters = $repository->findBy([], [], $limit, $offset);

        return $this->json($scooters);
    }
}

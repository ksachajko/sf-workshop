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
        $ids = $request->query->get('ids', null);

        //$scooters = $repository->findAll();
        // $scooters = $repository->findBy([], [], $limit, $offset);
        // $scooters = $repository->findBy(['name' => 'test'], [], $limit, $offset);
//        $scooters = $repository->findByName('Acme');
//        $scooters = $repository->findByNameAndSpeed('Acme', 30);
        $scooters = $repository->findById([4,5]);

//        if ($ids) {
//            $idsArray = explode(',', $ids);
//        }

//        $scooters = $repository->findBy([], [], $limit, $offset);

        $scooter = $repository->findUsingDQL(4);
        $scooter = $repository->veryCostlySQLQuery(4);

        return $this->json($scooter);
    }

    #[Route('/scooters/filter', name: 'app_scooters_filter')]
    public function filter(Request $request, ScooterRepository $repository): Response
    {
        $limit = $request->query->get('limit', 10);
        $offset = $request->query->get('offset', 0);
        $ids = $request->query->get('ids', null);

        $scooters = $repository->findFilteredBy($ids, $limit, $offset);

        return $this->json($scooters);
    }
}

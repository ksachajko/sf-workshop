<?php

namespace App\Controller;

use App\Entity\Scooter;
use App\Repository\ScooterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ScootersController extends AbstractController
{
    #[Route('/scooters', name: 'app_scooters', methods: ['GET'])]
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

    #[Route('/scooters/{id}', name: 'app_scooters_get', methods: ['GET'])]
    public function getSingle($id, ScooterRepository $repository): Response
    {
        $scooter = $repository->findById($id);

        if (!$scooter) {
            return new Response('', 404);
        }

        return $this->json($scooter);
    }

    #[Route('/scooters/{id}', name: 'app_scooters_remove', methods: ['DELETE'])]
    public function remove($id, ScooterRepository $repository): Response
    {
        $scooter = $repository->findOneById($id);

        if (!$scooter) {
            return new Response('', 404);
        }

        $repository->remove($scooter);

        return new Response('', 204);
    }

    #[Route('/scooters/{id}', name: 'app_scooters_update', methods: ['PUT'])]
    public function update(
        $id,
        ScooterRepository $repository,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        Request $request
    ): Response
    {
        // fetch existing Scooter
        /** @var Scooter $scooter */
        $scooter = $repository->findOneById($id);

        if (!$scooter) {
            return new Response('', 404);
        }

        // Updated data
        /** @var Scooter $updatedScooter */
        $updatedScooter = $serializer->deserialize($request->getContent(), Scooter::class, 'json');

        // validation
        $errors = $validator->validate($updatedScooter);
        if (count($errors)) {
            return new JsonResponse($this->mapErrors($errors), 400);
        }

        $scooter->setName($updatedScooter->getName());
        $scooter->setSpeed($updatedScooter->getSpeed());
        $scooter->setProductionDate($updatedScooter->getProductionDate());

        $repository->add($scooter);

        return new Response('', 204);
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

    #[Route('/scooters', name: 'app_scooters_add', methods: ['POST'])]
    public function add(
        Request $request,
        ScooterRepository $repository,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): Response
    {
        $scooter = $serializer->deserialize($request->getContent(), Scooter::class, 'json');

        $errors = $validator->validate($scooter);
        if (count($errors)) {
            return new JsonResponse($this->mapErrors($errors), 400);
        }

        $repository->add($scooter);

        return new Response(null, 201);
    }

    private function mapErrors(ConstraintViolationListInterface $errors): array
    {
        $errorMessages = [];

        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $errorMessages[] = [
                'path' => $error->getPropertyPath(),
                'message' => $error->getMessage()
            ];
        }

        return $errorMessages;
    }
}

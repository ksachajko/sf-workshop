<?php

namespace App\Controller;

use App\Controller\Request\Person;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TestController extends AbstractController
{
    #[Route('/test', name: 'test')]
    public function index(): Response
    {
        return new Response(
            'Hello world'
        );
    }

    #[Route('/hello/{name}', name: 'hello')]
    public function hello($name): Response
    {
        return new Response(
            'Hello ' . $name
        );
    }

    #[Route('/request', name: 'request')]
    public function request(Request $request): Response
    {
        $limit = $request->query->get('limit');

        return new Response(
            'Limit: ' . $limit
        );
    }

    #[Route('/save', name: 'save')]
    public function save(Request $request, SerializerInterface $serializer): Response
    {
        $person = $serializer->deserialize($request->getContent(), Person::class ,'json');

        return new Response(
            'Name : ' . $person->getName()
        );
    }
}

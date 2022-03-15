<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function wildcard($name): Response
    {
        return new Response(
            'Hello ' . $name
        );
    }
}

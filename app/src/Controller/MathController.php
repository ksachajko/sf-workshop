<?php

namespace App\Controller;

use App\Service\MathService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MathController extends AbstractController
{
    #[Route('/math/add/{number1}/{number2}', name: 'app_math')]
    public function add($number1, $number2, MathService $service): Response
    {
        $result = $service->add($number1,$number2);

        return new Response(
            'Result: ' . $result
        );
    }
}

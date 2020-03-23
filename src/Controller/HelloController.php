<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HelloController extends AbstractController
{
    public const KILOMETERS_PER_MILES = 1.609;

    public function hello()
    {
        $response = new Response();
        $response->setContent("Bonjour tout le monde!"."\n");
        $response->headers->set("Content-Type", "text/plain");
        $response->setStatusCode(Response::HTTP_PARTIAL_CONTENT);

        return $response;
    }

    public function convert(int $kilometers){
        $miles = $kilometers / self::KILOMETERS_PER_MILES;

        return $this->json([
            'kilometers' => $kilometers,
            'miles' => $miles
        ]);
    }

}
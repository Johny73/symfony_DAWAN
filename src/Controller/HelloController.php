<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class HelloController
{
    public function hello()
    {
        $response = new Response();
        $response->setContent("Bonjour tout le monde!"."\n");
        $response->headers->set("Content-Type", "text/plain");
        $response->setStatusCode(Response::HTTP_PARTIAL_CONTENT);

        return $response;
    }

}
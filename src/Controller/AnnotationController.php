<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AnnotationController extends AbstractController
{
    /**
     * @Route("/annotation", name="annotation")
     */
    public function index()
    {
        return $this->render('annotation/index.html.twig', [
            'controller_name' => 'AnnotationController',
        ]);
    }
}

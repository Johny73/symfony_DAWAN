<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AnnotationController extends AbstractController
{
    /**
     * @Route("/annotation", name="annotation")
     */
    /*Si plus bas avant une fonction on refait une déclaration de route, celui ci s'ajoute derriere celui créé au début.
    Pe /annotationxxxx */
    public function index()
    {
        return $this->render('annotation/index.html.twig', [
            'controller_name' => 'AnnotationController',
        ]);
    }
}

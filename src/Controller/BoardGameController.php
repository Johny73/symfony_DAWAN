<?php

namespace App\Controller;

use App\Entity\BoardGame;
use App\Repository\BoardGameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/board-game")
 */
class BoardGameController extends AbstractController
{
    /**
     * @Route("", methods="GET")
     */
    public function index(BoardGameRepository $repository)
    {
        $boardGames = $repository->findAll();
        /* $boardGames = $repository->findBy(['ageGroup' => 10]);*/

        return $this->render('board_game/index.html.twig', [
            'board_games' => $boardGames,
          ]);
    }


    /**
     * @Route("/{id}", requirements={"id": "\d+"})
     * le composant ParamConverter est capable de traduire un paramètre de route en :
     * -entité
     * --\Datetime
     */
         public function show(BoardGame $boardGame)
    {
        return $this->render('board_game/show.html.twig', [
            'board_game' => $boardGame,
        ]);
    }
    /**
     * @Route("/new")
     */
    public function new()
    {
        $game = new BoardGame();
        $form = $this->createFormBuilder($game) /*le fait de passer game en paramètre crée un lien entre le form et les tables*/
            ->add('name')
            ->add('description')
            ->add('releasedAt', DateType::class, [
                'html5'=>true,
                'widget' => 'single_text',
            ])
            ->add('ageGroup')
            ->getForm();

        return $this->render('board_game/new.html.twig',[
            'new_form' => $form->createview(),
        ]);
    }
}

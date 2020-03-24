<?php

namespace App\Controller;

use App\Repository\BoardGameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}

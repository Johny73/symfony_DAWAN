<?php

namespace App\Controller;

use App\Entity\BoardGame;
use App\Repository\BoardGameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route({
 *     "en": "/board-game",
 *     "fr": "/jeu-societe"})
 */
class BoardGameController extends AbstractController
{
    /**
     * @Route("/search/{query}", methods="GET")
     */
    public function search(string $query, BoardGameRepository $repository){
        $games = $repository->findBySearchQuery($query);

        return $this->json($games, Response::HTTP_OK, [],
            [AbstractNormalizer::IGNORED_ATTRIBUTES =>['classifiedIn','authorIs',
                ]
            ]);
    }


    /**
     * @Route("", methods="GET")
     */
    public function index(BoardGameRepository $repository)
    {
        $boardGames = $repository->findWithCategories();
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
         public function show(BoardGame $boardGame, ValidatorInterface $validator)
    {
        /* pour faire une validation des données hors formulaire, il faut ajouter le validatorinterface dans les paramètres et ajouter la ligne ci-dessous*/
        $errors = $validator->validate($boardGame);
        return $this->render('board_game/show.html.twig', [
            'board_game' => $boardGame,
        ]);
    }

}

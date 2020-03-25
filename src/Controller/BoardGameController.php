<?php

namespace App\Controller;

use App\Entity\BoardGame;
use App\Repository\BoardGameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\BoardGameType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
         public function show(BoardGame $boardGame, ValidatorInterface $validator)
    {
        /* pour faire une validation des données hors formulaire, il faut ajouter le validatorinterface dans les paramètres et ajouter la ligne ci-dessous*/
        $errors = $validator->validate($boardGame);
        return $this->render('board_game/show.html.twig', [
            'board_game' => $boardGame,
        ]);
    }

    /**
     * @Route("/edit/{id}", requirements={"id": "\d+"}, methods={"GET", "PUT"})
     */
    public function edit(BoardGame $game, Request $request, EntityManagerInterface $manager)
    {
       $form = $this->createForm(BoardGameType::class, $game, [
            'method' => 'PUT',
        ]);

        $form->HandleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('succes', 'Modifications enrégistrées');

            return $this->redirectToRoute('app_boardgame_show', [
                'id' => $game->getId(),
            ]);
        }

        return $this->render('board_game/edit.html.twig',[
            'edit_form' => $form->createview(),]);
    }

    /**
     * @Route("/new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $manager)
    {
        $game = new BoardGame();
        $form = $this->createForm(BoardGameType::class, $game);


        $form->HandleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($game);
            $manager->flush();

            $this->addFlash('succes', 'Nouveau jeu ajouté');
            return $this->redirectToRoute('app_boardgame_show', [
                'id' => $game->getId(),
            ]);
            }

        return $this->render('board_game/new.html.twig',[
            'new_form' => $form->createview(),
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\BoardGame;
use App\Repository\BoardGameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/edit/{id}", requirements={"id": "\d+"})
     */
    public function edit(BoardGame $boardGame, Request $request, EntityManagerInterface $manager)
    {
        $game = $boardGame;
        $form = $this->createFormBuilder($game)
        ->add('name', null, ['label' => 'Nom'])
            ->add('description', null, ['label' => 'Description'])
            ->add('releasedAt', DateType::class, [
                'html5' => true,
                'widget' => 'single_text',
                'label' => 'Date de sortie',
            ])
            ->add('ageGroup', null, ['label' => 'A partir de '])
            ->getForm();

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
        $form = $this->createFormBuilder($game) /*le fait de passer game en paramètre crée un lien entre le form et les tables*/
            ->add('name', null, ['label' =>'Nom'])
            ->add('description', null, ['label' => 'Description'])
            ->add('releasedAt', DateType::class, [
                'html5'=>true,
                'widget' => 'single_text',
                'label' => 'Date de sortie',
            ])
            ->add('ageGroup', null, ['label' => 'A partir de '])
            ->getForm();

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

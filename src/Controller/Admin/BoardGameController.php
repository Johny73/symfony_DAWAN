<?php


namespace App\Controller\Admin;


use App\Entity\BoardGame;
use App\Entity\User;
use App\Form\BoardGameType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 *@Route("/admin/board-game")
 * @IsGranted("ROLE_ADMIN")
 */
class BoardGameController extends AbstractController
{
    /**
     * @Route("/edit/{id}", requirements={"id": "\d+"}, methods={"GET", "PUT"})
     */
    public function edit(BoardGame $game, Request $request, EntityManagerInterface $manager)
    {
        /* Bloquer l'accès à la modif si user <> author*/
        if($game->getAuthorIs() != $this->getUser()){
            throw $this->createAccessDeniedException();
        }
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
        $game->setAuthorIs($this->getUser());
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
<?php

namespace App\Controller;

use App\PokerSquares\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    private Game $game;

    private function getGame(SessionInterface $session) {

        // Get game from session, or create if it not exists in session
        $this->game = $session->get('square_game', new Game());
    }

    private function saveGame(SessionInterface $session): void
    {
        $session->set('square_game', $this->game);
    }

    #[Route('/proj', name: "project")]
    public function proj(): Response
    {
        return $this->render('project/project.html.twig');
    }


    #[Route('/proj/about', name: "proj_about")]
    public function projAbout(): Response
    {
        return $this->render('project/about.html.twig');
    }


    #[Route('/proj/start', name: "start_game")]
    public function startGame(SessionInterface $session): Response
    {

        $this->game = new Game();
        $session->set('square_game', $this->game);


        $data = [
            'grid' => $this->game->getGrid(),
            'card' => $this->game->getCurrentCard(),
            'emptyCells' => $this->game->getEmptyCells(),
            'scores' => $this->game->calculateScores()
        ];

        return $this->render('project/board.html.twig', $data);
    }

    #[Route("/proj/draw", name: "draw_card", methods: ["POST"])]
    public function drawCard(SessionInterface $session): Response
    {
        $this->getGame($session);

        $data = [
            'grid' => $this->game->getGrid(),
            'card' => $this->game->drawCard(),
            'emptyCells' => $this->game->getEmptyCells(),
            'scores' => $this->game->calculateScores()
        ];

        $this->saveGame($session);

        return $this->render('project/board.html.twig', $data);
    }


    #[Route("/proj/placecard", name: "place_card", methods: ["POST"])]
    public function placeCard(Request $request, SessionInterface $session): Response
    {

        $this->getGame($session);

        $row = (int) $request->request->get('row');
        $col = (int) $request->request->get('col');

        $this->game->placeCard($row, $col);

        $nextCard = $this->game->drawCard();

        $this->saveGame($session);

        $scores = $this->game->calculateScores();



        $data = [
            'grid' => $this->game->getGrid(),
            'card' => $nextCard,
            'emptyCells' => $this->game->getEmptyCells(),
            'scores' => $this->game->calculateScores()
        ];

        //var_dump($scores);

        return $this->render('project/board.html.twig', $data);

    }

}

<?php

namespace App\Controller;

use App\PokerSquares\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    private Game $game;

    /**
     * Get current game from session
     *
     * @param SessionInterface $session
     * @return void
     */
    private function getGame(SessionInterface $session): void
    {
        // Get game from session. If it not exists, create a new game
        $game = $session->get('square_game', new Game('Username'));

        if ($game instanceof Game) {
            $this->game = $game;
        }
    }

    /**
     * Save current game to session
     *
     * @param SessionInterface $session
     * @return void
     */
    private function saveGame(SessionInterface $session): void
    {
        $session->set('square_game', $this->game);
    }

    #[Route('/proj', name: "project")]
    public function proj(SessionInterface $session): Response
    {
        // Remove game session if it exists
        $session->remove('square_game');
        return $this->render('project/project.html.twig');

    }


    #[Route('/proj/about', name: "proj_about")]
    public function projAbout(): Response
    {
        return $this->render('project/about.html.twig');
    }


    /**
     * Undocumented function
     *
     * @param Request $request
     * @param SessionInterface $session
     * @return Response
     */
    #[Route('/proj/start', name: "start_game", methods: ["POST"])]
    public function startGame(Request $request, SessionInterface $session): Response
    {
        $playerName = (string)$request->request->get('playerName');
        $scoring = (string)$request->request->get('scoring');

        $this->game = new Game($playerName, $scoring);
        $session->set('square_game', $this->game);


        $data = [
            'grid' => $this->game->getGrid(),
            'card' => $this->game->getCurrentCard(),
            'emptyCells' => $this->game->getEmptyCells(),
            'scores' => $this->game->calculateScores($this->game->getScoringSystem()),
            'scoring' => $this->game->getScoringSystem(),
            'player' => $this->game->getPlayerName()
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
            'scores' => $this->game->calculateScores($this->game->getScoringSystem()),
            'scoring' => $this->game->getScoringSystem(),
            'player' => $this->game->getPlayerName()
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

        $scores = $this->game->calculateScores($this->game->getScoringSystem());

        $data = [
            'grid' => $this->game->getGrid(),
            'card' => $nextCard,
            'emptyCells' => $this->game->getEmptyCells(),
            'scores' => $scores,
            'scoring' => $this->game->getScoringSystem(),
            'player' => $this->game->getPlayerName()
        ];

        //var_dump($scores);

        return $this->render('project/board.html.twig', $data);

    }


}

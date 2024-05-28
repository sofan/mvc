<?php

namespace App\Controller;

use App\PokerSquares\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectControllerApi extends AbstractController
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

    #[Route("/proj/api", name: "proj_api_start")]
    public function apiStart(): Response
    {
        return $this->render('project/api.html.twig');
    }


    #[Route("/proj/api/game", name: "proj_api_game")]
    public function apiGame(SessionInterface $session): JsonResponse
    {

        $data = ['poker_squares' => 'No game is started'];

        if ($session->has('square_game')) {

            $this->getGame($session);

            $jsonGrid = $this->game->getJsonGrid();

            $data = [
                'poker_squares' => [
                    'player' => [
                        'name' => $this->game->getPlayerName(),
                        'scoringSystem' => $this->game->getScoringSystem()
                    ],
                    'board' => $jsonGrid
                ]
            ];
        }

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return $response;
    }



    #[Route("/proj/api/score", name: "proj_api_score")]
    public function apiScore(SessionInterface $session): JsonResponse
    {

        $data = ['score' => 'No game is started'];

        if ($session->has('square_game')) {

            $this->getGame($session);

            $scoreAmerican = $this->game->calculateScores();

            $this->game->setScoringSystem('british');
            $scoreBrittish = $this->game->calculateScores();

            $data = [
                'score' => [
                    'american' => $scoreAmerican,
                    'brittish' => $scoreBrittish
                ]
            ];
        }


        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return $response;
    }



    #[Route("/proj/api/player", name: "proj_api_player")]
    public function apiPlayer(SessionInterface $session): JsonResponse
    {

        $data = ['player' => 'No game is started'];

        if ($session->has('square_game')) {

            $this->getGame($session);

            $player = $this->game->getPlayerName();

            $data = [
                'player' => [
                    'name' => $player
                ]
            ];
        }


        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return $response;
    }


    #[Route("/proj/api/cells", name: "proj_api_cells")]
    public function apiCells(SessionInterface $session): JsonResponse
    {

        $data = ['cells' => 'No game is started'];

        if ($session->has('square_game')) {

            $this->getGame($session);

            $numCells = $this->game->getEmptyCells();

            $data = [
                'cells' => [
                    'empty' => $numCells
                ]
            ];
        }


        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return $response;
    }


    #[Route("/proj/api/system", name: "proj_api_system_post", methods: ["POST"])]
    public function handleScoringSystem(Request $request, SessionInterface $session): JsonResponse
    {
        $scoringSystem = (string)   $request->request->get('scoring');

        $data = ['cells' => 'No game is started'];

        if ($session->has('square_game')) {

            $this->getGame($session);

            $score = $this->game->calculateScores();

            $data = [
                'scoring' => [
                    'system' => $scoringSystem,
                    'score' => $score
                ]
            ];
        }


        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return $response;

    }



}

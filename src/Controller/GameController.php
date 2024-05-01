<?php

namespace App\Controller;

use App\Game\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * GameController class - controls the game
 */
class GameController extends AbstractController
{
    /**
     * Start the game
     *
     * @return Response
     */
    #[Route("/game", name: "game_start")]
    public function gameStart(): Response
    {
        return $this->render('game/game.html.twig');
    }


    /**
     * Show game documentation
     *
     * @return Response
     */
    #[Route("/game/doc", name: "game_doc")]
    public function gameDoc(): Response
    {
        return $this->render('game/doc.html.twig');
    }


    /**
     * Initiate a new game
     */
    #[Route("/game/init", name: "game_init")]
    public function gameInit(SessionInterface $session): Response
    {
        // init new game and save to session
        $game = new Game();
        $session->set("game", $game);

        return $this->redirectToRoute('game_new_round');
    }

    /**
     * Initiate a new game round
     */
    #[Route("/game/round", name: "game_new_round")]
    public function gameNewRound(SessionInterface $session): Response
    {
        // create a new round and save to session
        /**
         * @var Game
         */
        $game = $session->get('game', new Game());
        $game->newRound();
        $session->set('game', $game);

        return $this->redirectToRoute('game_play');
    }


    /**
     * Show card game
     */
    #[Route("/game/play", name: "game_play")]
    public function gamePlay(SessionInterface $session): Response
    {
        // get game from session
        $game = $session->get('game', new Game());

        $data = [
            "game" => $game
        ];

        return $this->render('game/play.html.twig', $data);
    }



    /**
     * Route to draw card
     *
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/game/draw", name: "game_draw_card")]
    public function gameDraw(SessionInterface $session): Response
    {
        // get game from session
        /**
         * @var Game
         */
        $game = $session->get('game', new Game());
        $game->currentPlayerTurn();

        $session->set("game", $game);

        if ($game->gameIsOver() && $game->getWinner()) {
            $this->addFlash(
                'notice',
                'Spelet är över! Vinnare är ' . $game->getWinner()->getName()
            );
        }

        return $this->redirectToRoute('game_play');
    }


    /**
     * Route to switch to next player
     */

    #[Route("/game/switch", name: "game_switch_player")]
    public function gameSwitchPlayer(SessionInterface $session): Response
    {
        // get game from session
        /**
         * @var Game
         */
        $game = $session->get('game', new Game());
        $game->swichPlayer();

        $session->set("game", $game);

        return $this->redirectToRoute('game_play');
    }


    /**
     * Route to set game bet
     *
     * @param SessionInterface $session
     * @param Request $request
     * @return Response
     */
    #[Route("/game/bet", name: "game_bet", methods: ["POST"])]
    public function gameBet(SessionInterface $session, Request $request): Response
    {
        $betAmount = (int)$request->request->get('bet_amount');

        // get game from session
        /**
         * @var Game
         */
        $game = $session->get('game', new Game());
        $game->setBet($betAmount);

        $this->addFlash(
            'notice',
            'Insats ändrad till ' . $betAmount . ' kr!'
        );

        return $this->redirectToRoute('game_play');
    }


}

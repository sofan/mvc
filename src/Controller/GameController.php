<?php

namespace App\Controller;

use App\Game\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route("/game", name: "game_start")]
    public function gameStart(): Response
    {
        return $this->render('game/game.html.twig');
    }


    #[Route("/game/doc", name: "game_doc")]
    public function gameDoc(): Response
    {
        return $this->render('game/doc.html.twig');
    }


    #[Route("/game/init", name: "game_init")]
    public function gameInit(SessionInterface $session): Response
    {
        // init new game
        $game = new Game();
        $session->set("game", $game);

        return $this->redirectToRoute('game_play');
    }


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

        return $this->redirectToRoute('game_play');
    }


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
}

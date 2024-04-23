<?php

namespace App\Controller;

use App\Game\Game;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class GameControllerJson
{
    #[Route("/api/game", name: "api_game")]
    public function apiGame(SessionInterface $session): JsonResponse
    {
        // get game from session
        /**
         * @var Game
         */
        $game = $session->get('game', new Game());

        $data = [
            'game' => [
            'player' => [
                'score' => $game->getPlayer()->getScore(),
                'money' => $game->getPlayer()->getMoney(),
                'hand' => $game->getPlayer()->getHand()->toArray()
            ],
            'dealer' => [
                'score' => $game->getDealer()->getScore(),
                'money' => $game->getDealer()->getMoney(),
                'hand' => $game->getDealer()->getHand()->toArray()
            ]]
        ];


        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );


        return $response;

    }

}

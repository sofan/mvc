<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardControllerJson extends AbstractController
{

    #[Route("/api/deck", name: "api_deck", methods: ['GET'])]
    public function apiDeck(SessionInterface $session): JsonResponse
    {
        $deck = new DeckOfCards();

        $session->set("deck", $deck);

        $cardArray = $deck->getCardArray();

        $data = [
            'deckOfCards' => $cardArray
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return $response;
    }



    #[Route("/api/deck/shuffle", name: "api_deck_shuffle_post", methods: ['POST'])]
    public function apiDeckShuffle_post(SessionInterface $session): Response
    {
        return $this->redirectToRoute('api_deck_shuffle_get');
    }


    #[Route("/api/deck/shuffle", name: "api_deck_shuffle_get", methods: ['GET'])]
    public function apiDeckShuffle_get(SessionInterface $session): JsonResponse
    {
        // Get session or new DeckOfCards of session not exists
        $deck = $session->get('deck', new DeckOfCards());
        $deck->shuffle();

        $cards = [];
        foreach ($deck->getCards() as $card) {
            $cards[] = [
            'suit' => $card->getSuit(),
            'value' => $card->getValue()
            ];
        }

        $data = [
            'deckOfCards' => $cards
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return $response;
    }


    #[Route("/api/deck/draw", name: "api_deck_draw", methods: ['POST'])]
    public function apiDeckDrawPost(SessionInterface $session): Response
    {
        return $this->redirectToRoute('api_deck_draw_get', ['number' => 1]);
    }


    #[Route("/api/deck/draw/{number<\d+>}", name: "api_deck_draw_num", methods: ['POST'])]
    public function apiDeckDrawNumPost(Request $request, SessionInterface $session, int $number): Response
    {
        $numCards = $request->request->get('num_cards');

        return $this->redirectToRoute('api_deck_draw_get', ['number' => $numCards]);
    }



    #[Route("/api/deck/draw/{number<\d+>}", name: "api_deck_draw_get", methods: ['GET'])]
    public function apiDeckDraw_get(SessionInterface $session, int $number): JsonResponse
    {
        // Get session or new DeckOfCards of session not exists
        $deck = $session->get('deck', new DeckOfCards());

        $drawnCards = $deck->draw($number);
        $session->set("deck", $deck);

        $session->set("drawCards", $drawnCards);

        $cards = [];
        foreach ($drawnCards as $card) {
            $cards[] = [
            'suit' => $card->getSuit(),
            'value' => $card->getValue()
            ];
        }

        $data = [
            'cards' => $cards,
            'cardsLeft' => $deck->getNumberOfCards()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return $response;
    }

}

<?php

namespace App\Controller;

use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardControllerJson extends AbstractController
{
    public function createDeckOfCards(): DeckOfCards
    {
        $deck = new DeckOfCards();

        foreach ($deck->getSuits() as $suit) {
            foreach ($deck->getValues() as $value) {
                $deck->addCard(new CardGraphic($suit, $value));
            }
        }
        return $deck;
    }

    #[Route("/api/deck", name: "api_deck", methods: ['GET'])]
    public function apiDeck(SessionInterface $session): JsonResponse
    {
        $deck = $this->createDeckOfCards();

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
    public function apiDeckShufflePost(): Response
    {
        return $this->redirectToRoute('api_deck_shuffle_get');
    }


    #[Route("/api/deck/shuffle", name: "api_deck_shuffle_get", methods: ['GET'])]
    public function apiDeckShuffleGet(SessionInterface $session): JsonResponse
    {
        // Get session or new DeckOfCards of session not exists
        /**
         * @var DeckOfCards
         */
        $deck = $session->get('deck', $this->createDeckOfCards());
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
    public function apiDeckDrawPost(): Response
    {
        return $this->redirectToRoute('api_deck_draw_get', ['number' => 1]);
    }


    #[Route("/api/deck/draw/{number<\d+>}", name: "api_deck_draw_num", methods: ['POST'])]
    public function apiDeckDrawNumPost(Request $request): Response
    {
        $numCards = $request->request->get('num_cards');

        return $this->redirectToRoute('api_deck_draw_get', ['number' => $numCards]);
    }



    #[Route("/api/deck/draw/{number<\d+>}", name: "api_deck_draw_get", methods: ['GET'])]
    public function apiDeckDrawGet(SessionInterface $session, int $number): JsonResponse
    {
        // Get session or new DeckOfCards of session not exists
        /**
         * @var DeckOfCards
         */
        $deck = $session->get('deck', $this->createDeckOfCards());

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


    #[Route("/api/deck/deal/{players<\d+>}/{cards<\d+>}", name: "api_card_hand_post", methods: ['POST'])]
    public function apiCardHandPost(Request $request): Response
    {
        $numPlayers = (int)$request->request->get('num_players');
        $numCards = (int)$request->request->get('num_player_cards');

        return $this->redirectToRoute('api_card_hand', ['players' => $numPlayers, 'cards' => $numCards ]);
    }

    #[Route("/api/deck/deal/{players<\d+>}/{cards<\d+>}", name: "api_card_hand", methods: ['GET'])]
    public function apiCardHandGet(int $players, int $cards): JsonResponse
    {
        // Create new deck of cards (or get from session), shuffle and add to session
        $deckOfCards = $this->createDeckOfCards();
        $deckOfCards->shuffle();

        $cardHands = [];

        // Create players
        for ($i = 1; $i <= $players; $i++) {

            $hand = new CardHand();

            // Draw cards from deck and add to players hand
            $playerCards = $deckOfCards->draw((int)$cards);
            $hand->addCards($playerCards);
            $cardHands[] = $hand;
        }


        $cardHandsData = [];
        foreach ($cardHands as $hand) {
            $cardHandsData[] = $hand->toArray();
        }

        $data = [
            'hands' => $cardHandsData,
            'cardsLeft' => $deckOfCards->getNumberOfCards()
        ];


        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return $response;
    }

}

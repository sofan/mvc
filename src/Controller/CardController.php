<?php

namespace App\Controller;

use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
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

    #[Route("/session", name: "session_info")]
    public function sessionShow(SessionInterface $session): Response
    {
        $allSessions = $session->all();

        $data = [
            "sessionData" => $allSessions
        ];

        return $this->render('session.html.twig', $data);
    }



    #[Route("/session/delete", name: "session_delete")]
    public function sessionDelete(SessionInterface $session): Response
    {
        $session->clear();

        $this->addFlash(
            'notice',
            'Sessionen är raderad!'
        );

        return $this->redirectToRoute('session_info');
    }


    #[Route("/card", name: "card_start")]
    public function cardStart(): Response
    {
        return $this->render('card/card.html.twig');
    }


    #[Route("/card/deck", name: "card_deck")]
    public function cardDeck(SessionInterface $session): Response
    {
        /**
         * @var DeckOfCards
         */
        $deck = $session->get("deck", $this->createDeckOfCards());
        //$deck->sort();

        // Add to session
        $session->set("deck", $deck);
        $data = [
            "title" => "Sorterad kortlek",
            "cards" => $deck->getCards()
        ];

        return $this->render('card/deck.html.twig', $data);
    }



    /**
     * Sort deck of cards
     *
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/card/deck/sort", name: "card_deck_sort")]
    public function deckSort(SessionInterface $session): Response
    {
        /**
         * @var DeckOfCards
         */
        $deck = $session->get("deck", $this->createDeckOfCards());

        $deck->sort();
        $session->set("deck", $deck);
        return $this->redirectToRoute('card_deck');

    }


    /**
     * init new deck of cards
     *
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/card/deck/init", name: "card_deck_init")]
    public function cardDeckInit(SessionInterface $session): Response
    {
        // Create new deck of cards
        $deck = $this->createDeckOfCards();

        $session->set("deck", $deck);

        return $this->redirectToRoute('card_deck');

    }



    #[Route("/card/deck/shuffle", name: "card_deck_shuffled")]
    public function shuffleCards(SessionInterface $session): Response
    {
        /**
         * @var DeckOfCards
         */
        $deck = $session->get("deck", $this->createDeckOfCards());

        $deck->shuffle();
        $session->set("deck", $deck);
        $data = [
            "title" => "Blandad kortlek",
            "cards" => $deck->getCards()
        ];

        return $this->render('card/deck.html.twig', $data);
    }



    /**
     * Functino to draw cards from deck
     *
     * @param SessionInterface $session
     * @param integer $number
     * @return Response
     */
    private function drawFromDeck(SessionInterface $session, int $number = 1): Response
    {

        /**
         * @var DeckOfCards
         */
        $deck = $session->get("deck", $this->createDeckOfCards());

        $drawnCards = $deck->draw($number);
        $session->set("deck", $deck);

        $data = [
            "title" => "Dragna kort",
            "cards" => $drawnCards,
            "cardsLeft" => $deck->getNumberOfCards()
        ];

        return $this->render('card/draw.html.twig', $data);
    }



    #[Route("/card/deck/draw", name: "card_deck_draw")]
    public function drawCard(SessionInterface $session): Response
    {
        return $this->drawFromDeck($session, 1);
    }


    #[Route("/card/deck/draw/{number<\d+>}", name: "card_deck_draw_num")]
    public function drawCardNum(SessionInterface $session, int $number): Response
    {
        return $this->drawFromDeck($session, $number);
    }


    #[Route("/card/deck/deal/{players<\d+>}/{cards<\d+>}", name: "card_hand", methods: ['GET'])]
    public function cardHand(SessionInterface $session, int $players, int $cards): Response
    {
        // Get deckOfCards from session (or create new of session not exists)
        /**
         * @var DeckOfCards
         */
        $deck = $session->get("deck", $this->createDeckOfCards());

        $cardHands = [];

        // Create players
        for ($i = 1; $i <= $players; $i++) {

            $hand = new CardHand($i);

            // Draw cards from deck and add to players hand
            $playerCards = $deck->draw((int)$cards);
            $hand->addCards($playerCards);
            $cardHands[] = $hand;
        }

        $data = [
            "numCards" => $cards,
            "numPlayers" => $players,
            "hands" => $cardHands,
            "cardsLeft" => $deck->getNumberOfCards()
        ];

        $session->set("cardHands", $cardHands);

        return $this->render('card/hand.html.twig', $data);
    }



    /**
     * Route to init CardHand
     *
     * @param Request $request
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/card/hand/init", name: "card_hand_init", methods: ["POST"])]
    public function createCardHand(Request $request, SessionInterface $session): Response
    {
        // Create new deck of cards, shuffle and add to session
        /**
         * @var DeckOfCards
         */
        $deckOfCards = $this->createDeckOfCards();
        $deckOfCards->shuffle();
        $session->set("deck", $deckOfCards);

        // Get number of players and cards from form input
        $players = (int) $request->request->get('players');
        $cards = (int) $request->request->get('cards');

        return $this->redirectToRoute(
            'card_hand',
            [
                'players' => $players,
                'cards' => $cards
            ]
        );
    }
}

<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{

    #[Route("/session", name: "session_info")]
    public function session_show(SessionInterface $session): Response
    {
        $allSessions = $session->all();

        $data = [
            "sessionData" => $allSessions
        ];

        return $this->render('session.html.twig', $data);
    }



    #[Route("/session/delete", name: "session_delete")]
    public function session_delete(SessionInterface $session): Response
    {
        $session->clear();

        $this->addFlash(
            'notice',
            'Sessionen är raderad!'
        );

        return $this->redirectToRoute('session_info');
    }


    #[Route("/card", name: "card_start")]
    public function card_start(): Response
    {
        return $this->render('card/card.html.twig');
    }


    #[Route("/card/deck", name: "card_deck")]
    public function card_deck(SessionInterface $session): Response
    {
        $deck = null;
        if ($session->has("deck")) {
            $deck = $session->get("deck");
            $deck->sort();
        }
        else {
            $deck = new DeckOfCards();
        }

        $session->set("deck", $deck);
        $data = [
            "title" => "Sorterad kortlek",
            "cards" => $deck->getCards()
        ];

        return $this->render('card/deck.html.twig', $data);
    }


    #[Route("/card/deck/init", name: "card_deck_init")]
    public function card_deck_init(SessionInterface $session): Response
    {
        $deck = new DeckOfCards();

        $session->set("deck", $deck);
        $data = [
            "title" => "Ny kortlek",
            "cards" => $deck->getCards()
        ];

        return $this->render('card/deck.html.twig', $data);
    }



    #[Route("/card/deck/shuffle", name: "card_deck_shuffled")]
    public function shuffle_cards(SessionInterface $session): Response
    {
        $deck = null;
        if ($session->has("deck")) {
            $deck = $session->get("deck");
        }
        else {
            $deck = new DeckOfCards();
        }

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
    private function drawFromDeck(SessionInterface $session, int $number = 1) : Response {

        $deck = $session->get("deck");
        if (!$deck instanceof DeckOfCards) {
            $deck = new DeckOfCards();
        }

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
    public function draw_card(SessionInterface $session): Response
    {
        return $this->drawFromDeck($session, 1);
    }


    #[Route("/card/deck/draw/{number<\d+>}", name: "card_deck_draw_num")]
    public function draw_card_num(SessionInterface $session, int $number): Response
    {
        return $this->drawFromDeck($session, $number);
    }


    #[Route("/card/deck/deal/{players<\d+>}/{cards<\d+>}", name: "card_deal")]
    public function deal_cards(SessionInterface $session): Response
    {
        $deck = null;
        if ($session->has("deck")) {
            $deck = $session->get("deck");
        }
        else {
            $deck = new DeckOfCards();
        }

        $deck->shuffle();
        $session->set("deck", $deck);
        $data = [
            "title" => "Blandad kortlek",
            "cards" => $deck->getCards()
        ];

        return $this->render('card/deck.html.twig', $data);
    }
}

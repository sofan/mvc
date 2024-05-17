<?php

namespace App\Service;

use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Card\Card;
use App\Card\CardGraphic;

class DeckService
{
    /**
     * Create Deck of cards
     *
     * @param string $cardType
     * @return DeckOfCards
     */
    public function createDeckOfCards(string $cardType = 'Graphic'): DeckOfCards
    {
        $deck = new DeckOfCards();

        foreach ($deck->getSuits() as $suit) {
            foreach ($deck->getValues() as $value) {
                $card = ($cardType === 'Graphic') ? new CardGraphic($suit, $value) : new Card($suit, $value);
                $deck->addCard($card);
            }
        }

        return $deck;
    }



    /**
     * Deal cards
     *
     * @param DeckOfCards $deck
     * @param integer $players
     * @param integer $cardsPerPlayer
     * @return array<CardHand>
     */
    public function dealCardsToPlayers(DeckOfCards $deck, int $players, int $cardsPerPlayer): array
    {
        $cardHands = [];

        for ($i = 1; $i <= $players; $i++) {
            $hand = new CardHand();
            $playerCards = $deck->draw($cardsPerPlayer);
            $hand->addCards($playerCards);
            $cardHands[] = $hand;
        }

        return $cardHands;
    }
}

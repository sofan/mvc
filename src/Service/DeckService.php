<?php

namespace App\Service;

use App\Card\DeckOfCards;
use App\Card\CardGraphic;

class DeckService
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
}

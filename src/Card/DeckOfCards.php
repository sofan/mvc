<?php

namespace App\Card;

use App\Card\Card;

class DeckOfCards
{
    private $cards = [];
    private $suits = [Suit::HEARTS, Suit::SPADES, Suit::CLUBS, Suit::DIAMONDS];
    private $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];



    public function __construct()
    {
        $this->cards = [];

        foreach ($this->suits as $suit) {
            foreach ($this->values as $value) {
                $this->cards[] = new CardGraphic($suit, $value);
            }
        }
    }

    public function getCards() {
        return $this->cards;
    }


    /**
     * Function to sort cards
     *
     * @return void
     */
    public function sort() {

        usort($this->cards, function($a, $b) {
            // Jämför suit först
            $suitOrderA = array_search($a->getSuit(), $this->suits);
            $suitOrderB = array_search($b->getSuit(), $this->suits);
            $suitComparison = $suitOrderA - $suitOrderB;
            if ($suitComparison !== 0) {
                return $suitComparison;
            }

            // Jämför value sen
            $numA = array_search($a->getValue(), $this->values);
            $numB = array_search($b->getValue(), $this->values);
            return $numA - $numB;

        });
    }

    /**
     * Shuffles tha deck of cards
     *
     * @return void
     */
    public function shuffle() {
        shuffle($this->cards);
    }


    /**
     * Draw card from deck
     *
     * @return array
     */
    public function draw($num = 1) {

        // Take the first card in deck
        //return array_shift($this->cards);
        $drawCards = array_splice($this->cards, 0, $num);

        return $drawCards;
    }


    /**
     * Get number of cards left
     *
     * @return int
     */
    public function getNumberOfCards() {
        return count($this->cards);
    }


    public function getString(): array
    {
        $values = [];
        foreach ($this->cards as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }
}

<?php

namespace App\Card;

use App\Card\Card;

class DeckOfCards
{
    private $cards = [];
    private $suits = [Suit::HEARTS, Suit::SPADES, Suit::CLUBS, Suit::DIAMONDS];
    private $values;

    public function __construct($graphic = true, $values = null)
    {
        // If no values parameter, use default 13 cards
        $this->values = $values ?? Suit::getValues13();

        $this->cards = [];

        foreach ($this->suits as $suit) {
            foreach ($this->values as $value) {
                $this->cards[] = $graphic ? new CardGraphic($suit, $value) : new Card($suit, $value);
            }
        }
    }

    public function getCards()
    {
        return $this->cards;
    }


    /**
     * Function to sort cards
     *
     * @return void
     */
    public function sort()
    {

        usort($this->cards, function ($a, $b) {
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
    public function shuffle()
    {
        shuffle($this->cards);
    }


    /**
     * Draw card from deck
     *
     * @return array
     */
    public function draw($num = 1)
    {
        // get num cards from the array
        $drawnCards = array_splice($this->cards, 0, $num);

        return $drawnCards;
    }


    /**
     * Get number of cards left
     *
     * @return int
     */
    public function getNumberOfCards()
    {
        return count($this->cards);
    }



    public function getCardArray()
    {
        $cards = [];
        foreach ($this->cards as $card) {
            $cards[] = [
            'suit' => $card->getSuit(),
            'value' => $card->getValue()
            ];
        }

        return $cards;
    }
}

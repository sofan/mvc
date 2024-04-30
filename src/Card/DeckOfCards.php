<?php

namespace App\Card;

use App\Card\Card;

class DeckOfCards
{
    /**
     * @var Card[]
     */
    private $cards = [];

    /**
     * @var string[]
     */
    private $suits = ['Hearts', 'Clubs', 'Spades', 'Diamonds'];

    /**
     * @var string[]
     */
    private $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];

    public function __construct()
    {
        $this->cards = [];

    }



    /**
     * Get suits
     *
     * @return string[]
     */
    public function getSuits(): array
    {
        return $this->suits;
    }

    /**
     * Get values
     *
     * @return string[]
     */
    public function getValues()
    {
        return $this->values;
    }

    public function addCard(Card $card): void
    {
        $this->cards[] = $card;
    }

    /**
     * Get cards
     *
     * @return Card[]
     */
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
        usort($this->cards, function (Card $first, Card $second) {
            // Jämför suit först
            $suitOrderA = (int)array_search($first->getSuit(), $this->suits);
            $suitOrderB = (int)array_search($second->getSuit(), $this->suits);

            $suitComparison = ($suitOrderA - $suitOrderB);
            if ($suitComparison !== 0) {
                return $suitComparison;
            }

            // Jämför value sen
            $numA = (int)array_search($first->getValue(), $this->values);
            $numB = (int)array_search($second->getValue(), $this->values);

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
     * @return Card[]
     */
    public function draw(int $num = 1): array
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



    /**
     * Get cards as array, to use for JSON
     *
     * @return array<int<0, max>, array<string, string>>
     */
    public function getCardArray(): array
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

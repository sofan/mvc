<?php

namespace App\Card;

class CardHand
{
    /**
     * Array of cards
     *
     * @var Card[]
     */
    private $cards = [];



    public function __construct()
    {
        $this->cards = [];
    }

    /**
     * Add card to hand
     *
     * @param Card $card
     * @return void
     */
    public function addCard(Card $card)
    {
        $this->cards[] = $card;
    }


    /**
     * Add card to hand
     *
     * @param Card[] $cards
     * @return void
     */
    public function addCards($cards)
    {
        $this->cards = array_merge($this->cards, $cards);
    }


    /**
     * Get cards in hand
     *
     * @return Card[]
     */
    public function getCards(): array
    {
        return $this->cards;
    }


    /**
     * Undocumented function
     *
     * @return array{cards: array<int<0, max>, array{suit: string, value: string}>}
     */
    public function toArray(): array
    {
        $cardsData = [];
        foreach ($this->cards as $card) {
            $cardsData[] = [
                "suit" => $card->getSuit(),
                "value" => $card->getValue()
            ];
        }
        return [
            'cards' => $cardsData,
        ];
    }

    /**
     * Get total score for card hand
     *
     * @return int
     */
    public function getTotalScore()
    {

        $totalScore = 0;
        foreach ($this->cards as $card) {
            $totalScore += $card->getScore();
        }
        return $totalScore;
    }

}

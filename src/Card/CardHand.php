<?php

namespace App\Card;

/**
 * CardHand class - respresents a hand of playering cards
 */
class CardHand
{
    /**
     * Array of cards
     *
     * @var Card[]
     */
    private $cards = [];


    /**
     * CardHand contructor, intit an empty hand
     */
    public function __construct()
    {
        $this->cards = [];
    }

    /**
     * Add card to hand
     *
     * @param Card $card The card to add
     * @return void
     */
    public function addCard(Card $card)
    {
        $this->cards[] = $card;
    }


    /**
     * Add card to hand
     *
     * @param Card[] $cards Array of card to add
     * @return void
     */
    public function addCards($cards)
    {
        $this->cards = array_merge($this->cards, $cards);
    }


    /**
     * Get cards in hand
     *
     * @return Card[] The cards array
     */
    public function getCards(): array
    {
        return $this->cards;
    }


    /**
     * Get cards as array in JSON format
     *
     * @return array{cards: array<int, array{suit: string, value: string}>}
     *
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
     * @return int Total score of hand
     */
    public function getTotalScore()
    {

        $totalScore = 0;
        $numAces = 0;

        foreach ($this->cards as $card) {

            $value = $card->getScore();

            if ($value === 1) {
                // Hantera Ess separat
                $numAces++;
            }

            if ($value > 1) {
                $totalScore += $value;
            }

        }

        // Lägg till essens värde baserat på den totala poängen
        for ($i = 0; $i < $numAces; $i++) {
            // Lägg till 1 eller 11 beroende på handens värde
            $valueToAdd = ($totalScore + 11 <= 21) ? 11 : 1;
            $totalScore += $valueToAdd;
        }

        return $totalScore;
    }

}

<?php

namespace App\Card;

class CardHand
{
    /**
     * Player id
     *
     * @var int
     */
    private $playerId;

    /**
     * Array of cards
     *
     * @var Card[]
     */
    private $cards = [];

    public function __construct(int $playerId)
    {
        $this->playerId = $playerId;
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


    public function getPlayer(): int
    {
        return $this->playerId;
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
     * @return array{playerId: int, cards: array<int<0, max>, array{suit: string, value: string}>}
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
            'playerId' => $this->playerId,
            'cards' => $cardsData,
        ];
    }

}

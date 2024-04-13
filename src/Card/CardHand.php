<?php

namespace App\Card;


class CardHand
{
    private $playerId;
    private $cards = [];

    public function __construct($playerId)
    {
        $this->playerId = $playerId;
    }

    /**
     * Add card to hand
     *
     * @param array $card
     * @return void
     */
    public function addCards($cards)
    {
        $this->cards = array_merge($this->cards, $cards);
    }


    public function getPlayer()
    {
        return $this->playerId;
    }

    public function getCards()
    {
        return $this->cards;
    }

    public function toArray()
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

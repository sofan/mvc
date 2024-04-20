<?php

namespace App\Card;

class CardGraphic extends Card
{
    /**
     *
     * @param string $suit
     * @param string $value
     */
    public function __construct(string $suit, string $value)
    {
        parent::__construct($suit, $value);
    }
    /**
     * Get suit as graphic
     *
     * @return string
     */
    public function getAsString(): string
    {
        switch($this->getSuit()) {
            case 'Hearts':
                return '♥️' . $this->getValue();
            case 'Clubs':
                return '♣️' . $this->getValue();
            case 'Spades':
                return '♠️' . $this->getValue();
            case 'Diamonds':
                return '♦️' . $this->getValue();
            default:
                return '-';
        }
    }
}

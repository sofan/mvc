<?php

namespace App\Card;

class CardGraphic extends Card
{
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

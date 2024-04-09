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
        $graphic = Suit::getGraphic($this->getSuit());
        $value = $this->getValue();
        return "$graphic $value";
    }
}
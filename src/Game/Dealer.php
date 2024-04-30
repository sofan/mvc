<?php

namespace App\Game;

use App\Card\Card;

/**
 * Dealer class
 */
class Dealer extends Player
{
    /**
     * Constructor
     *
     * @param integer $money
     */
    public function __construct(int $money)
    {
        parent::__construct("Bank", $money); // Anropa Players konstruktor
    }


    public function checkStopThreshold(): void
    {
        // Stop dealer if
        if ($this->getScore() >= 17) {
            $this->stop();
        }
    }

    /**
     * Override player
     *
     * @param Card $card
     * @return void
     */
    public function addCard(Card $card)
    {
        parent::addCard($card);
        $this->checkStopThreshold();
    }

}

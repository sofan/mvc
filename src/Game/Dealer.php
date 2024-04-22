<?php

namespace App\Game;

use App\Card\Card;

/**
 * Dealer class
 */
class Dealer extends Player
{
    public function __construct()
    {
        parent::__construct("Bank"); // Anropa Players konstruktor
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

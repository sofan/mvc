<?php

namespace App\Game;

use App\Card\Card;

/**
 * Dealer class - Respresents a Dealer type of Player
 */
class Dealer extends Player
{
    /**
     * Dealer Constructor
     *
     * @param integer $money money to start with
     */
    public function __construct(int $money)
    {
        parent::__construct("Bank", $money); // Anropa Players konstruktor
    }


    /**
     * Function to check if dealer shall stop current round,
     * sets player to stopped if total score >= 17
     *
     * @return void
     */
    public function checkStopThreshold(): void
    {
        // Stop dealer if
        if ($this->getScore() >= 17) {
            $this->stop();
        }
    }

    /**
     * Add card to dealer
     *
     * @param Card $card Card to add
     * @return void
     */
    public function addCard(Card $card)
    {
        parent::addCard($card);
        $this->checkStopThreshold();
    }

}

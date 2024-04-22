<?php

namespace App\Game;

use App\Card\Card;
use App\Card\CardHand;

/**
 * Player class
 */
class Player
{
    /**
     * Player name
     *
     * @var string
     */
    private $name;



    /**
     * Tells of player has stopped
     *
     * @var bool
     */
    private $stopped;



    /**
     * Players card hand
     *
     * @var CardHand
     */
    private $hand;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->hand = new CardHand();
        $this->stopped = false;
    }



    /**
     * Get player name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }




    /**
     * Add card to hand
     *
     * @return void
     */
    public function addCard(Card $card)
    {
        $this->hand->addCard($card);
    }


    /**
     * Get players card hand
     *
     * @return CardHand
     */
    public function getHand()
    {
        return $this->hand;
    }

    /**
     * Get players total score
     *
     * @return int
     */
    public function getScore(): int
    {
        return $this->hand->getTotalScore();
    }

    /**
     * Set player as stopped
     *
     * @return void
     */
    public function stop()
    {
        $this->stopped = true;
    }

    public function isStopped(): bool
    {
        return $this->stopped;
    }




}

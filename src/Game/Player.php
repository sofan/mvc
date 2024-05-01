<?php

namespace App\Game;

use App\Card\Card;
use App\Card\CardHand;

/**
 * Player class - represents a card game player
 */
class Player
{
    /**
     * Player name
     *
     * @var string Name of the player
     */
    private $name;

    /**
     * Tells of player has stopped
     *
     * @var bool Trus if player has stopped current round
     */
    private $stopped;

    /**
     * Players card hand
     *
     * @var CardHand Players card hand
     */
    private $hand;


    /**
     * Players money
     *
     * @var int players money
     */
    private $money;


    /**
     * Player constructor
     *
     * @param string $name name of player
     * @param integer $money money to start with
     */
    public function __construct(string $name, int $money)
    {
        $this->name = $name;
        $this->hand = new CardHand();
        $this->stopped = false;
        $this->money = $money;
    }


    /**
     * Get player name
     *
     * @return string The name of the player
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * Add card
     *
     * @param Card $card Card to add to player
     * @return void
     */
    public function addCard(Card $card)
    {
        $this->hand->addCard($card);
    }


    /**
     * Get players card hand
     *
     * @return CardHand Players CardHand
     */
    public function getHand()
    {
        return $this->hand;
    }



    /**
     * Reset the CardHand and stop players round
     *
     * @return void
     */
    public function resetHand(): void
    {
        // Create new hand and set stopped to false
        $this->hand = new CardHand();
        $this->stopped = false;
    }

    /**
     * Get players total score
     *
     * @return int score
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


    /**
     * Returns players stopped status
     *
     * @return boolean Trus if player has stopped
     */
    public function isStopped(): bool
    {
        return $this->stopped;
    }


    /**
     * Get players money
     *
     * @return integer money
     */
    public function getMoney(): int
    {
        return $this->money;
    }

    /**
     * Update player money, $change can be positive or negative
     *
     * @param integer $change Money change, can be positive or negative
     * @return void
     */
    public function updateMoney(int $change)
    {
        $this->money += (int)$change;
    }


}

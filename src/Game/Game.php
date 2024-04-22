<?php

namespace App\Game;

use App\Card\CardGraphic;
use App\Card\DeckOfCards;

/**
 * Game class
 */
class Game
{
    /**
     * Players
     *
     * @var Player
     */
    private $player;

    /**
     * Dealer, the bank
     *
     * @var Player
     */
    private $dealer;

    /**
     * Takes care of which turn it is to draw a card
     *
     * @var Player | null
     */
    private $currentPlayer;

    /**
     * The winner
     *
     * @var Player|null
     */
    private $winner;

    /**
     * Deck of cards
     *
     * @var DeckOfCards
     */
    private $deck;

    public function __construct()
    {
        // Create player and bank
        $this->player = new Player('Spelare');
        $this->dealer = new Dealer();

        // Let the player start
        $this->currentPlayer = $this->player;

        // Create and shuffle the cards
        $this->deck = new DeckOfCards();
        foreach ($this->deck->getSuits() as $suit) {
            foreach ($this->deck->getValues() as $value) {
                $this->deck->addCard(new CardGraphic($suit, $value));
            }
        }
        $this->deck->shuffle();

        $this->winner = null;

    }


    public function getCurrentPlayer(): Player | null
    {
        return $this->currentPlayer;
    }

    /**
     * Get player
     *
     * @return Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Get player
     *
     * @return Player
     */
    public function getDealer()
    {
        return $this->dealer;
    }

    /**
     * Switch player
     *
     * @return void
     */
    public function swichPlayer()
    {
        // Stop current player and switch to dealer
        if ($this->currentPlayer) {
            $this->currentPlayer->stop();
            $this->currentPlayer = $this->dealer;
        }
    }


    /**
     * Let current player draw a card from deck
     *
     * @return void
     */
    public function currentPlayerTurn()
    {
        $card = $this->deck->draw();
        if ($this->currentPlayer) {
            $this->currentPlayer->addCard($card[0]);
        }
        $this->checkResult();
    }



    /**
     * Get game result
     *
     * @return void
     */
    public function checkResult()
    {

        $playerScore = $this->player->getScore();
        $dealerScore = $this->dealer->getScore();

        if ($playerScore === 21) {
            $this->winner = $this->player;
        } elseif ($dealerScore === 21) {
            $this->winner = $this->dealer;
        } elseif ($playerScore > 21) {
            $this->winner = $this->dealer;
        } elseif ($dealerScore > 21) {
            $this->winner = $this->player;
        } elseif ($this->dealer->isStopped()) {
            $this->winner = ($dealerScore >= $playerScore) ? $this->dealer : $this->player;
        }

    }


    /**
     * Get winner
     *
     * @return Player|null
     */
    public function getWinner()
    {
        return $this->winner;
    }

}

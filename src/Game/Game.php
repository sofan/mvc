<?php

namespace App\Game;

use App\Card\CardGraphic;
use App\Card\DeckOfCards;

/**
 * Game class - takes care of the Game logic
 */
class Game
{
    /**
     * Players
     *
     * @var Player The player
     */
    private $player;

    /**
     * Dealer, the bank
     *
     * @var Player The Bank
     */
    private $dealer;

    /**
     * Current player, takes care of which turn it is to draw a card
     *
     * @var Player | null
     */
    private $currentPlayer;

    /**
     * The winner, represents the winner of the game
     *
     * @var Player|null
     */
    private $winner;

    /**
     * Deck of cards
     *
     * @var DeckOfCards The deck of cards
     */
    private $deck;

    /**
     * Bet for current round
     *
     * @var int Game bet
     */
    private $bet;




    /**
     * Game constructor
     *
     * @param integer $startMoney money to start with for both player and bank
     */
    public function __construct(int $startMoney = 100)
    {
        // Create player and bank
        $this->player = new Player('Spelare', $startMoney);
        $this->dealer = new Dealer($startMoney);

        $this->newRound();

    }



    /**
     * Get current player
     *
     * @return Player | null Returns the current player
     */
    public function getCurrentPlayer(): Player | null
    {
        return $this->currentPlayer;
    }

    /**
     * Get player
     *
     * @return Player The player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Get player
     *
     * @return Dealer The dealer/bank
     */
    public function getDealer()
    {
        return $this->dealer;
    }

    /**
     * Switch to next player
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
     * Get game bet
     *
     * @return integer the bet
     */
    public function getBet(): int
    {
        return $this->bet;
    }



    /**
     * Set game bet
     *
     * @param integer $bet game bet to set
     * @return void
     */
    public function setBet(int $bet): void
    {
        $this->bet = $bet;
    }



    /**
     * Initiate a new round. Create a new deckOfCards and clear player and dealers CardHand
     *
     * @return void
     */
    public function newRound(): void
    {

        // Reset hands for player and dealer
        $this->player->resetHand();
        $this->dealer->resetHand();
        $this->deck = new DeckOfCards();

        foreach ($this->deck->getSuits() as $suit) {
            foreach ($this->deck->getValues() as $value) {
                $this->deck->addCard(new CardGraphic($suit, $value));
            }
        }

        //$this->deck->fillWithGraphicCards();
        $this->deck->shuffle();

        // Let the player start
        $this->currentPlayer = $this->player;
        $this->bet = 10; // Default bet
        $this->winner = null;
    }



    /**
     * Check game result. Set winner if it exists
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

        $this->updateMoney();
    }


    /**
     * Function to update money when round is over
     *
     * @return void
     */
    public function updateMoney(): void
    {

        // Vinnaren får från banken lika mycket som den satsat
        if ($this->winner) {
            $this->winner->updateMoney($this->bet);

            if ($this->player === $this->winner) {
                // Dra pengar från banken
                $this->dealer->updateMoney(-$this->bet);
            }

            if ($this->dealer === $this->winner) {
                // Dra pengar från spelaren
                $this->player->updateMoney(-$this->bet);
            }
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


    /**
     * Check if game is over (if player or dealer has no money left)
     *
     * @return boolean gameover
     */
    public function gameIsOver(): bool
    {
        return $this->player->getMoney() <= 0 || $this->dealer->getMoney() <= 0;
    }



}

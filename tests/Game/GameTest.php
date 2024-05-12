<?php

namespace App\Game;

use App\Card\Card;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Game
 */
class GameTest extends TestCase
{
    /**
     * test to create a Dealer
     *
     * @return void
     */
    public function testCreateGame()
    {

        $game = new Game();

        $player = $game->getPlayer();
        $dealer = $game->getDealer();

        // Assert player and dealer classes
        $this->assertInstanceOf(Player::class, $player);
        $this->assertInstanceOf(Dealer::class, $dealer);

    }

    /**
     * test to create a Dealer
     *
     * @return void
     */
    public function testCreateGameWithMoney()
    {

        $game = new Game(50);

        $playerMoney = $game->getPlayer()->getMoney();
        $dealerMoney = $game->getDealer()->getMoney();

        // Assert player and dealer classes
        $this->assertEquals(50, $playerMoney);
        $this->assertEquals(50, $dealerMoney);

    }


    /**
     * test get current player
     *
     * @return void
     */
    public function testGetCurrentPlayer()
    {

        $game = new Game();

        $currentPlayer = $game->getCurrentPlayer();
        $player = $game->getPlayer();
        $dealer = $game->getDealer();

        $this->assertEquals($currentPlayer, $player);

        // Switch player and check that current player is changed to dealer
        $game->swichPlayer();
        $currentPlayer = $game->getCurrentPlayer();

        $this->assertEquals($currentPlayer, $dealer);

    }

    /**
     * test to set and get game bet
     *
     * @return void
     */
    public function testSetAndGetBet()
    {

        $game = new Game();

        $game->setBet(30);

        $bet = $game->getBet();

        $this->assertEquals(30, $bet);
    }


    /**
     * Test currentplayers turn, that he recieves a card from deck
     *
     * @return void
     */
    public function testCurrentPlayersTurn()
    {

        $game = new Game();

        $game->currentPlayerTurn();

        $playerHand = $game->getPlayer()->getHand()->getCards();

        $exp = 1;

        $this->assertCount($exp, $playerHand);

    }


    /**
     * test check result with player as winner
     *
     * @return void
     */
    public function testCheckResultPlayerWins()
    {

        $game = new Game();

        $player = $game->getPlayer();

        // Make player winner
        $player->addCard(new Card('Hearts', 'J'));
        $player->addCard(new Card('Hearts', '10'));

        $game->checkResult();

        $winner = $game->getWinner();

        $this->assertEquals($winner, $player);
    }


    /**
     * test check result with dealer as winner
     *
     * @return void
     */
    public function testCheckResultDealerWinsWith21()
    {

        $game = new Game();

        $dealer = $game->getDealer();

        // Make dealer winner
        $dealer->addCard(new Card('Hearts', 'J'));
        $dealer->addCard(new Card('Hearts', '10'));

        $game->checkResult();

        $winner = $game->getWinner();

        $this->assertEquals($winner, $dealer);
    }

    /**
    * test check result with dealer as winner
    *
    * @return void
    */
    public function testCheckResultPlayerOver21()
    {

        $game = new Game();

        $player = $game->getPlayer();
        $dealer = $game->getDealer();

        // Make dealer winner
        $player->addCard(new Card('Hearts', 'J'));
        $player->addCard(new Card('Hearts', '10'));
        $player->addCard(new Card('Hearts', '5'));

        $game->checkResult();

        $winner = $game->getWinner();

        $this->assertEquals($winner, $dealer);
    }

    /**
    * test check result with dealer as winner
    *
    * @return void
    */
    public function testCheckResultDealerOver21()
    {

        $game = new Game();

        $player = $game->getPlayer();
        $dealer = $game->getDealer();

        $dealer->addCard(new Card('Hearts', 'J'));

        // Make player winner
        $player->addCard(new Card('Hearts', 'J'));
        $player->addCard(new Card('Hearts', '3'));

        $dealer->addCard(new Card('Hearts', 'J'));
        $dealer->addCard(new Card('Hearts', '10'));
        $dealer->addCard(new Card('Hearts', '5'));

        $game->checkResult();

        $winner = $game->getWinner();

        $this->assertEquals($winner, $player);
    }



    /**
     * test check result when scores are equal (dealer wins)
     *
     * @return void
     */
    public function testCheckResultEqualScore()
    {

        $game = new Game();

        $player = $game->getPlayer();
        $player->addCard(new Card('Hearts', '9'));
        $player->addCard(new Card('Hearts', '10'));

        $dealer = $game->getDealer();
        $dealer->addCard(new Card('Hearts', '9'));
        $dealer->addCard(new Card('Hearts', '10'));

        $game->checkResult();

        $winner = $game->getWinner();

        $this->assertEquals($winner, $dealer);
    }




}

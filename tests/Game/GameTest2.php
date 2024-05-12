<?php

namespace App\Game;

use App\Card\Card;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Game
 */
class GameTest2 extends TestCase
{
    /**
     * test check result when dealer has lower score
     *
     * @return void
     */
    public function testCheckResultDealerLowerScore()
    {

        $game = new Game();

        $player = $game->getPlayer();
        $player->addCard(new Card('Hearts', '9'));
        $player->addCard(new Card('Hearts', '10'));

        $dealer = $game->getDealer();
        $dealer->addCard(new Card('Hearts', '7'));
        $dealer->addCard(new Card('Hearts', '10'));

        $game->checkResult();

        $winner = $game->getWinner();

        $this->assertEquals($winner, $player);
    }


    /**
     * Test if game is over
     *
     * @return void
     */
    public function testGameIsOver()
    {

        $game = new Game(10);

        // Set players money to 0
        $game->getPlayer()->updateMoney(-10);

        $res = $game->gameIsOver();

        $this->assertTrue($res);
    }


}

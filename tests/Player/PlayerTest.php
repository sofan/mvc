<?php

namespace App\Game;

use App\Card\CardHand;
use App\Card\Card;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Player
 */
class PlayerTest extends TestCase
{
    /**
     * test to create a Player
     *
     * @return void
     */
    public function testCreatePlayer()
    {

        $expName = 'TestPlayer';
        $expMoney = 100;
        $player = new Player($expName, $expMoney);

        $name = $player->getName();
        $money = $player->getMoney();
        $playerStopped = $player->isStopped();
        $playerHand = $player->getHand();

        // Assert
        $this->assertEquals($expName, $name);
        $this->assertEquals($expMoney, $money);
        $this->assertInstanceOf(CardHand::class, $playerHand);
        $this->assertFalse($playerStopped);

    }


    /**
     * test add card to Player
     *
     * @return void
     */
    public function testAddCard()
    {

        $player = new Player('TestPlayer', 100);
        $card = new Card('Spades', '3');

        $player->addCard($card);

        $hand = $player->getHand();
        $cardInHand = $hand->getCards()[0];

        // Check that card hand exists of only one card
        $this->assertCount(1, $hand->getCards());

        // Check that returned card is the same as the added
        $this->assertEquals($cardInHand, $card);

    }


    /**
     * test reset players hand
     *
     * @return void
     */
    public function testResetHand()
    {

        $player = new Player('TestPlayer', 100);
        $card = new Card('Spades', '3');

        $player->addCard($card);

        $player->resetHand();
        $hand = $player->getHand();
        $cards = $hand->getCards();

        // Check that hand is empty
        $this->assertEmpty($cards);

    }


    /**
     * test get score of players hand
     *
     * @return void
     */
    public function testGetScore()
    {

        $player = new Player('TestPlayer', 100);

        $player->addCard(new Card('Spades', '3'));
        $player->addCard(new Card('Heartes', 'K'));

        $score = $player->getScore();

        $exp = 16;

        // Check that hand is empty
        $this->assertEquals($exp, $score);
    }


    /**
     * test stop players game round
     *
     * @return void
     */
    public function testStop()
    {

        $player = new Player('TestPlayer', 100);
        $player->stop();

        $stopped = $player->isStopped();

        $this->assertTrue($stopped);
    }


    /**
     * test update players money, add money
     *
     * @return void
     */
    public function testUpdateAddMoney()
    {

        $player = new Player('TestPlayer', 100);

        $player->updateMoney(10);

        $res = $player->getMoney();

        $exp = 110;

        $this->assertEquals($exp, $res);

    }

    /**
     * test update players money, subtract money
     *
     * @return void
     */
    public function testUpdateSubtractMoney()
    {

        $player = new Player('TestPlayer', 100);

        $player->updateMoney(-10);

        $res = $player->getMoney();

        $exp = 90;

        $this->assertEquals($exp, $res);

    }

}

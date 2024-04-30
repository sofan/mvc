<?php

namespace App\Game;

use App\Card\Card;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dealer
 */
class DealerTest extends TestCase
{
    /**
     * test to create a Dealer
     *
     * @return void
     */
    public function testCreateDealer()
    {

        $dealer = new Dealer(100);

        $name = $dealer->getName();

        $exp = 'Bank';

        // Assert
        $this->assertEquals($exp, $name);
    }



    /**
     * test to add cards and chaeck that Dealer stops when score >= 17
     *
     * @return void
     */
    public function testAddCard()
    {

        $dealer = new Dealer(100);

        $dealer->addCard(new Card('Spades', 'Q'));
        $dealer->addCard(new Card('Heartes', 'K'));

        $res = $dealer->isStopped();

        // Cechk that dealer is stopped when score >= 17
        $this->assertTrue($res);
    }


}

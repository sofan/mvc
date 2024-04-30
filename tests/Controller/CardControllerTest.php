<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Game
 */
class CardControllerTest extends TestCase
{
    /**
     * test to create a DeckOfCards
     *
     * @return void
     */
    public function testCreateDeckOfCards()
    {

        $controller = new CardController();
        $deck = $controller->createDeckOfCards();

        $this->assertInstanceOf(DeckOfCards::class, $deck);
    }
}

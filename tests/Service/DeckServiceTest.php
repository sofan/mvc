<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\DeckService;
use App\Card\DeckOfCards;

class DeckServiceTest extends TestCase
{
    /**
     * Test create deckOfCards
     *
     * @return void
     */
    public function testCreateDeckOfCards()
    {
        $deckService = new DeckService();
        $deck = $deckService->createDeckOfCards();

        $this->assertInstanceOf(DeckOfCards::class, $deck);
        $this->assertCount(52, $deck->getCards()); // Testa att kortleken har 52 kort
    }
}

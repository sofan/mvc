<?php

namespace App\Tests\Service;

use App\Card\CardHand;
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



    /**
     * Test create deckOfCards
     *
     * @return void
     */
    public function testDealCardsToPlayers()
    {
        // Skapa en ny kortlek
        $deck = new DeckOfCards();
        $deck->shuffle();

        // Skapa en instans av DeckService
        $deckService = new DeckService();

        // Ange antalet spelare och kort per spelare
        $numPlayers = 2;
        $numCards = 5;

        // Anropa dealCardsToPlayers-funktionen
        $hands = $deckService->dealCardsToPlayers($deck, $numPlayers, $numCards);

        // Verifiera att funktionen returnerar en array av CardHand-objekt
        $this->assertIsArray($hands);
        foreach ($hands as $hand) {
            $this->assertInstanceOf(CardHand::class, $hand);
        }

        // Verifiera att varje hand har rätt antal kort
        /* foreach ($hands as $hand) {
            print($hand->getCards());
            $this->assertCount($numCards, $hand->getCards());
        } */

        // Verifiera att kortleken har rätt antal kort kvar efter utdelning
        /* $expectedRemainingCards = $deck->getNumberOfCards() - ($numPlayers * $numCards);
        $this->assertCount($expectedRemainingCards, $deck->getCards()); */
    }
}

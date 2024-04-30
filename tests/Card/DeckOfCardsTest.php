<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DeckOfCards
 */
class DeckOfCardsTest extends TestCase
{
    /**
     * test constructor and getCards function
     *
     * @return void
     */
    public function testCreateEmptyDeckOfCards()
    {

        $deck = new DeckOfCards();

        // Assert
        $this->assertIsArray($deck->getCards());
        $this->assertEmpty($deck->getCards());
    }


    /**
     * test getSuits
     *
     * @return void
     */
    public function testGetSuitsAndValue()
    {

        $deck = new DeckOfCards();

        $exp = ['Hearts', 'Clubs', 'Spades', 'Diamonds'];

        $res = $deck->getSuits();

        $this->assertEquals($exp, $res);

        $expValues = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];

        $resValues = $deck->getValues();

        $this->assertEquals($expValues, $resValues);

    }



    /**
     * test to add a card of class Card
     *
     * @return void
     */
    public function testAddCard()
    {

        // Arrange test
        $deck = new DeckOfCards();
        $card = new Card('Hearts', '3');

        // Do test
        $deck->addCard($card);

        // Assert
        $cards = $deck->getCards();
        // Check that cards array contains only 1 card
        $this->assertCount(1, $cards);

        // Check that card is the same as was added to hand
        $this->assertSame($card, $cards[0]);

    }


    /**
     * test to sort DeckOfCards
     *
     * @return void
     */
    public function testSort()
    {

        // Arrange test
        $deck = new DeckOfCards();

        $cards = [
            new Card('Hearts', 'A'),
            new Card('Clubs', '2'),
            new Card('Spades', 'K'),
            new Card('Diamonds', '3'),
            new Card('Clubs', 'Q'),
            new Card('Hearts', '3'),
        ];


        $exp = [
            new Card('Hearts', '3'),
            new Card('Hearts', 'A'),
            new Card('Clubs', '2'),
            new Card('Clubs', 'Q'),
            new Card('Spades', 'K'),
            new Card('Diamonds', '3'),
        ];

        foreach ($cards as $card) {
            $deck->addCard($card);
        }

        $deck->sort();
        $sortedCards = $deck->getCards();

        $this->assertEquals($exp, $sortedCards);
    }


    /**
     * test to shuffle DeckOfCards
     *
     * @return void
     */
    public function testShuffle()
    {

        $deck = new DeckOfCards();

        // Fill with cards
        $cards = [
            new Card('Hearts', 'A'),
            new Card('Clubs', '2'),
            new Card('Spades', 'K'),
            new Card('Diamonds', '3'),
            new Card('Clubs', 'Q'),
            new Card('Hearts', '3'),
        ];

        foreach ($cards as $card) {
            $deck->addCard($card);
        }

        $initialCards = $deck->getCards();

        $deck->shuffle();

        $shuffledCards = $deck->getCards();

        // Check that number of cards has not changed
        $this->assertCount(count($initialCards), $shuffledCards);

        // Check that arrays are not the same
        $this->assertNotEquals($initialCards, $shuffledCards);

        // Check that al cards remains in the Deck of cards
        foreach ($initialCards as $card) {
            $this->assertContains($card, $shuffledCards);
        }

    }


    /**
     * test to draw one card from the deck of cards
     *
     * @return void
     */
    public function testDrawOneCard()
    {

        $deck = new DeckOfCards();

        // Fill with cards
        $cards = [
            new Card('Hearts', 'A'),
            new Card('Clubs', '2'),
            new Card('Spades', 'K'),
            new Card('Diamonds', '3'),
            new Card('Clubs', 'Q'),
            new Card('Hearts', '3'),
        ];

        foreach ($cards as $card) {
            $deck->addCard($card);
        }

        $returnedCards = $deck->draw();

        // Check that card is the first in deck
        $this->assertEquals($cards[0], $returnedCards[0]);
    }


    /**
     * test to draw two cards from the deck of cards
     *
     * @return void
     */
    public function testDrawTwoCards()
    {

        $deck = new DeckOfCards();

        // Fill with cards
        $cards = [
            new Card('Hearts', 'A'),
            new Card('Clubs', '2'),
            new Card('Spades', 'K'),
            new Card('Diamonds', '3'),
            new Card('Clubs', 'Q'),
            new Card('Hearts', '3'),
        ];

        foreach ($cards as $card) {
            $deck->addCard($card);
        }


        $drawnCards = $deck->draw(2);

        // Check that 2 cards are returned
        $this->assertCount(2, $drawnCards);

        // Check that first 2 cards in deck are returned
        $this->assertEquals($cards[0], $drawnCards[0]);
        $this->assertEquals($cards[1], $drawnCards[1]);

    }


    /**
     * teset draw card from empty deck
     *
     * @return void
     */
    public function testDrawFromEmptyDeck()
    {

        $deck = new DeckOfCards();

        $drawnCards = $deck->draw();

        $this->assertEmpty($drawnCards);

    }


    /**
     * test get number of cards in the DeckOfCards
     *
     * @return void
     */
    public function testGetNumberOfCards()
    {

        $deck = new DeckOfCards();

        // Fill with cards
        $cards = [
            new Card('Hearts', 'A'),
            new Card('Clubs', '2'),
            new Card('Spades', 'K'),
        ];

        foreach ($cards as $card) {
            $deck->addCard($card);
        }

        $exp = 3;

        $res = $deck->getNumberOfCards();

        $this->assertEquals($exp, $res);

    }


    /**
     * test to get cards as array in json format
     *
     * @return void
     */
    public function testGetCardArray()
    {
        $deck = new DeckOfCards();

        // Fill with cards
        $cards = [
            new Card('Hearts', 'A'),
            new Card('Clubs', '2'),
            new Card('Spades', 'K'),
        ];

        foreach ($cards as $card) {
            $deck->addCard($card);
        }

        $exp = [
            ['suit' => 'Hearts', 'value' => 'A'],
            ['suit' => 'Clubs', 'value' => '2'],
            ['suit' => 'Spades', 'value' => 'K']
        ];

        $res = $deck->getCardArray();

        $this->assertEquals($exp, $res);

    }


}

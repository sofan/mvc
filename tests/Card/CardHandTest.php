<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardHand
 */
class CardHandTest extends TestCase
{
    /**
     * test constructor and getCards function
     *
     * @return void
     */
    public function testCreateEmptyCardHand()
    {

        $hand = new CardHand();

        // Assert
        $this->assertIsArray($hand->getCards());
        $this->assertEmpty($hand->getCards());
    }


    /**
     * test to add 1 card
     *
     * @return void
     */
    public function testAddCard()
    {

        // Arrange test
        $hand = new CardHand();
        $card = new Card('Hearts', '3');

        // Do test
        $hand->addCard($card);

        // Assert
        $cards = $hand->getCards();
        // Check that cards array contains only 1 card
        $this->assertCount(1, $cards);

        // Check that card is the same as was added to hand
        $this->assertSame($card, $cards[0]);

    }


    /**
     * function to be used in other testcases to create a CardHand
     *
     * @param array<array<string, string>> $cardsData
     * @return CardHand
     */
    private function createHandWithCards($cardsData): CardHand
    {
        $hand = new CardHand(); // Ersätt YourHandClass med namnet på din handklass
        foreach ($cardsData as $cardData) {
            $card = new Card($cardData['suit'], $cardData['value']);
            $hand->addCard($card);
        }
        return $hand;
    }


    /**
     * test to add card array
     *
     * @return void
     */
    public function testAddCards()
    {

        // Arrange test
        $hand = new CardHand();
        $cardsToAdd = [];
        $cardsToAdd[] = new Card('Hearts', '3');
        $cardsToAdd[] = new Card('Diamonds', 'K');

        // Do test
        $hand->addCards($cardsToAdd);

        // Assert
        $cards = $hand->getCards();
        // Check that cards array contains 2 cards
        $this->assertCount(2, $cards);

        // Check that cards are the same as was added to hand
        $this->assertSame($cardsToAdd, $cards);
    }


    /**
     * test get hand as array in JSON format
     *
     * @return void
     */
    public function testGetHandAsArray()
    {

        // Create hand
        $hand = $this->createHandWithCards([
            ['suit' => 'Hearts', 'value' => '3'],
            ['suit' => 'Diamonds', 'value' => 'K']
        ]);

        // Exprected result
        $exp = [
            'cards' => [
                ["suit" => 'Hearts', "value" => '3'],
                ["suit" => 'Diamonds', "value" => 'K']
            ]
        ];

        // Do test
        $res = $hand->toArray();

        // Assert
        $this->assertIsArray($res); // Check that result is an array
        $this->assertEquals($exp, $res); // Check expected result
        $this->assertArrayHasKey('cards', $res); // Check that result has key 'cards'
    }


    /**
     * test getTotalScore when no aces in CardHand
     *
     * @return void
     */
    public function testGetTotalScoreWithNoAces()
    {

        // Create hand
        $hand = $this->createHandWithCards([
            ['suit' => 'Spades', 'value' => '7'],
            ['suit' => 'Diamonds', 'value' => '5']
        ]);

        $exp = 12;

        $res = $hand->getTotalScore();

        // Assert
        $this->assertEquals($exp, $res);
    }


    /**
     * test getTotalScore when 1 ace is added to a hand that already has > 10 points
     *
     * @return void
     */
    public function testGetTotalScoreWithAceInLargeHand()
    {

        // Create hand
        $hand = $this->createHandWithCards([
            ['suit' => 'Spades', 'value' => '7'],
            ['suit' => 'Diamonds', 'value' => '5'],
            ['suit' => 'Diamonds', 'value' => 'A']
        ]);

        $exp = 13;

        $res = $hand->getTotalScore();

        // Assert
        $this->assertEquals($exp, $res);
    }

    /**
     * test getTotalScore when 1 ace is added to a hand that has score < 10 points
     *
     * @return void
     */
    public function testGetTotalScoreWithAceInSmallHand()
    {

        // Create hand
        $hand = $this->createHandWithCards([
            ['suit' => 'Spades', 'value' => '3'],
            ['suit' => 'Diamonds', 'value' => '2'],
            ['suit' => 'Diamonds', 'value' => 'A']
        ]);

        $exp = 16;

        $res = $hand->getTotalScore();

        // Assert
        $this->assertEquals($exp, $res);
    }
}

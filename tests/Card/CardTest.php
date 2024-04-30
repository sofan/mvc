<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card
 */
class CardTest extends TestCase
{
    /**
     * Test to create a Cards with suit and value parameters
     */
    public function testCreateCardWithSuitAndValue(): void
    {
        $suit = 'Ace';
        $value = '3';

        $card = new Card($suit, $value);

        // Assert
        $this->assertInstanceOf("\App\Card\Card", $card);
        $this->assertEquals($suit, $card->getSuit());
        $this->assertEquals($value, $card->getValue());

    }



    /**
     * @dataProvider cardDataValues
     */
    public function testGetScore(string $suit, string $value, int $expectedScore): void
    {
        $card = new Card($suit, $value);

        // Assert
        $this->assertEquals($expectedScore, $card->getScore());
    }

    /**
     * Test data for some suit and value combinations
     *
     * @return array<int|string>[]
     */
    public function cardDataValues()
    {
        return [
            ['Hearts', 'K', 13],
            ['Spades', 'Q', 12],
            ['Diamonds', 'J', 11],
            ['Clubs', 'A', 1],
            ['Hearts', '2', 2],
            ['Spades', '10', 10],
            ['Diamonds', '5', 5],
        ];
    }


    /**
     * Test get card suit and value as string
     *
     * @return void
     */
    public function testGetString(): void
    {

        // Arrange
        $card = new Card('Hearts', 'K');

        // Act
        $res = $card->getAsString();

        // Assert
        $exp = '[Hearts K]';
        $this->assertEquals($exp, $res);
    }
}

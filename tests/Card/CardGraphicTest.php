<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardGraphic
 */
class CardGraphicTest extends TestCase
{
    /**
     * @dataProvider cardDataValues
     */
    public function testGetString(string $suit, string $value, string $expected): void
    {

        // Arrange
        $card = new CardGraphic($suit, $value);

        // Act
        $res = $card->getAsString();

        // Assert
        $this->assertEquals($expected, $res);
    }

    /**
     * Test data for some suit and value combinations
     *
     * @return array<int|string>[]
     */
    public function cardDataValues()
    {
        return [
            ['Hearts', 'K', '♥️K'],
            ['Spades', 'Q', '♠️Q'],
            ['Diamonds', 'J', '♦️J'],
            ['Clubs', 'A', '♣️A'],
            ['Hearts', '2', '♥️2'],
            ['Spades', '10', '♠️10'],
            ['Diamonds', '5', '♦️5'],
            ['Other', '5', '-']
        ];
    }
}

<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceGraphic.
 */
class DiceGraphicTest extends TestCase
{
    public function testGetAsString(): void
    {

        $representation = [
            '⚀',
            '⚁',
            '⚂',
            '⚃',
            '⚄',
            '⚅',
        ];

        $dice = new DiceGraphic();

        // Gå igenom alla möjliga värden (1 till 6) och kontrollera deras representation.
        for ($value = 1; $value <= 6; $value++) {

            $dice->roll();

            $exp = $representation[$dice->getValue() - 1];

            $res = $dice->getAsString();

            $this->assertEquals($exp, $res);
        }
    }


}

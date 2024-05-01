<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class DiceHandTest extends TestCase
{
    /**
     * Stub the dices to assure the value can be asserted.
     */
    public function testAddStubbedDices(): void
    {
        // Create a stub for the Dice class.
        $stub = $this->createMock(Dice::class);

        // Configure the stub.
        $stub->method('roll')
            ->willReturn(6);
        $stub->method('getValue')
            ->willReturn(6);

        $dicehand = new DiceHand();
        $dicehand->add(clone $stub);
        $dicehand->add(clone $stub);
        $dicehand->roll();
        $res = $dicehand->sum();
        $this->assertEquals(12, $res);
    }

    /**
     * test add dice to hand
     *
     * @return void
     */
    public function testAddAddsDieToHand(): void
    {

        $diceHand = new DiceHand();

        $dice = new Dice();
        $diceHand->add($dice);

        $this->assertEquals(1, $diceHand->getNumberDices());
    }


    public function testRollRollsAllDiceInHand(): void
    {
        $diceHand = new DiceHand();

        $dice1 = new Dice();
        $dice2 = new Dice();
        $diceHand->add($dice1);
        $diceHand->add($dice2);

        $diceHand->roll();


        $values = $diceHand->getValues();

        foreach ($values as $value) {
            $this->assertGreaterThanOrEqual(1, $value);
            $this->assertLessThanOrEqual(6, $value);
        }
    }


    public function testGetStringReturnsArrayOfStrings(): void
    {
        $diceHand = new DiceHand();

        // Skapa två mock-objekt för Dice.
        $mockDice1 = $this->createMock(Dice::class);
        $mockDice2 = $this->createMock(Dice::class);

        // konfigurera beteende
        $mockDice1->method('getAsString')->willReturn('[1]');
        $mockDice2->method('getAsString')->willReturn('[2]');

        // Lägg till de mockade Dice-objekten
        $diceHand->add($mockDice1);
        $diceHand->add($mockDice2);

        $stringArray = $diceHand->getString();

        $this->assertEquals(['[1]', '[2]'], $stringArray);
    }
}

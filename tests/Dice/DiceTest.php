<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDice(): void
    {
        $die = new Dice();
        $this->assertInstanceOf("\App\Dice\Dice", $die);

        $res = $die->getAsString();
        $this->assertNotEmpty($res);
    }



    /**
     * Create a mocked object that always returns 6.
     */
    public function testStubRollDiceLastRoll(): void
    {
        // Create a stub for the Dice class.
        $stub = $this->createMock(Dice::class);

        // Configure the stub.
        $stub->method('roll')
            ->willReturn(6);

        $res = $stub->roll();
        $exp = 6;
        $this->assertEquals($exp, $res);
    }


    /**
     * test dice roll
     *
     * @return void
     */
    public function testRollDice(): void
    {
        $dice = new Dice();

        // Roll dice multiple times and collect values.
        $values = [];
        for ($i = 0; $i < 50; $i++) {
            $values[] = $dice->roll();
        }

        // Kontrollera att alla värden är inom det förväntade intervallet (1 till 6).
        $this->assertContainsOnly('integer', $values);

        foreach ($values as $value) {
            $this->assertLessThanOrEqual(6, $value);
            $this->assertGreaterThanOrEqual(1, $value);
        }
    }


    /**
     * test get value
     *
     * @return void
     */
    public function testGetValue(): void
    {

        $dice = new Dice();

        $dice->roll();

        $res = $dice->getValue();

        $this->assertGreaterThanOrEqual(1, $res);
        $this->assertLessThanOrEqual(6, $res);

    }
}

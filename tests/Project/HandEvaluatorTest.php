<?php

namespace App\PokerSquares;

use App\Card\Card;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class HandEvaluator
 */
class HandEvaluatorTest extends TestCase
{
    /**
     * test if one pair
     *
     * @return void
     */
    public function testOnePair()
    {

        $evaluator = new HandEvaluator();

        $card1 = new Card('Hearts', '2');
        $card2 = new Card('Spades', '5');
        $card3 = new Card('Clubs', 'K');
        $card4 = new Card('Hearts', '2');
        $card5 = new Card('Hearts', 'A');

        $hand = [$card1, $card2, $card3, $card4, $card5];

        $scoreAm = $evaluator->evaluateHand($hand, 'american');
        $scoreBr = $evaluator->evaluateHand($hand, 'british');

        $this->assertEquals($scoreAm, 2);
        $this->assertEquals($scoreBr, 1);
    }

    /**
     * test if two pairs
     *
     * @return void
     */
    public function testTwoPairs()
    {

        $evaluator = new HandEvaluator();

        $card1 = new Card('Hearts', '2');
        $card2 = new Card('Spades', '5');
        $card3 = new Card('Clubs', '5');
        $card4 = new Card('Hearts', '2');
        $card5 = new Card('Hearts', 'A');

        $hand = [$card1, $card2, $card3, $card4, $card5];

        $scoreAm = $evaluator->evaluateHand($hand, 'american');
        $scoreBr = $evaluator->evaluateHand($hand, 'british');

        $this->assertEquals($scoreAm, 5);
        $this->assertEquals($scoreBr, 3);
    }

    /**
     * test if three of a kind
     *
     * @return void
     */
    public function testThreeOfAKind()
    {

        $evaluator = new HandEvaluator();

        $card1 = new Card('Hearts', '5');
        $card2 = new Card('Spades', '5');
        $card3 = new Card('Clubs', '5');
        $card4 = new Card('Hearts', '2');
        $card5 = new Card('Hearts', 'A');

        $hand = [$card1, $card2, $card3, $card4, $card5];

        $scoreAm = $evaluator->evaluateHand($hand, 'american');
        $scoreBr = $evaluator->evaluateHand($hand, 'british');

        $this->assertEquals($scoreAm, 10);
        $this->assertEquals($scoreBr, 6);
    }


    /**
     * test if Straight
     *
     * @return void
     */
    public function testStraight()
    {

        $evaluator = new HandEvaluator();

        $card1 = new Card('Hearts', '10');
        $card2 = new Card('Spades', 'J');
        $card3 = new Card('Clubs', 'Q');
        $card4 = new Card('Hearts', 'A');
        $card5 = new Card('Hearts', 'K');

        $hand = [$card1, $card2, $card3, $card4, $card5];

        $scoreAm = $evaluator->evaluateHand($hand, 'american');
        $scoreBr = $evaluator->evaluateHand($hand, 'british');

        $this->assertEquals($scoreAm, 15);
        $this->assertEquals($scoreBr, 12);
    }


    /**
     * test if Flush
     *
     * @return void
     */
    public function testFlush()
    {

        $evaluator = new HandEvaluator();

        $card1 = new Card('Hearts', '10');
        $card2 = new Card('Hearts', '3');
        $card3 = new Card('Hearts', '6');
        $card4 = new Card('Hearts', 'A');
        $card5 = new Card('Hearts', 'K');

        $hand = [$card1, $card2, $card3, $card4, $card5];

        $scoreAm = $evaluator->evaluateHand($hand, 'american');
        $scoreBr = $evaluator->evaluateHand($hand, 'british');

        $this->assertEquals($scoreAm, 20);
        $this->assertEquals($scoreBr, 5);
    }


    /**
     * test if Full House
     *
     * @return void
     */
    public function testFullHouse()
    {

        $evaluator = new HandEvaluator();

        $card1 = new Card('Hearts', '10');
        $card2 = new Card('Clubs', '3');
        $card3 = new Card('Diamonds', '3');
        $card4 = new Card('Hearts', '10');
        $card5 = new Card('Hearts', '3');

        $hand = [$card1, $card2, $card3, $card4, $card5];

        $scoreAm = $evaluator->evaluateHand($hand, 'american');
        $scoreBr = $evaluator->evaluateHand($hand, 'british');

        $this->assertEquals($scoreAm, 25);
        $this->assertEquals($scoreBr, 10);
    }



    /**
     * test if Four of a kind
     *
     * @return void
     */
    public function testFourOfAKind()
    {

        $evaluator = new HandEvaluator();

        $card1 = new Card('Hearts', '3');
        $card2 = new Card('Clubs', '3');
        $card3 = new Card('Diamonds', '3');
        $card4 = new Card('Hearts', '10');
        $card5 = new Card('Hearts', '3');

        $hand = [$card1, $card2, $card3, $card4, $card5];

        $scoreAm = $evaluator->evaluateHand($hand, 'american');
        $scoreBr = $evaluator->evaluateHand($hand, 'british');

        $this->assertEquals($scoreAm, 50);
        $this->assertEquals($scoreBr, 16);
    }


    /**
     * test if Straight Flush
     *
     * @return void
     */
    public function testStraightFlush()
    {

        $evaluator = new HandEvaluator();

        $card1 = new Card('Hearts', '9');
        $card2 = new Card('Hearts', '10');
        $card3 = new Card('Hearts', 'J');
        $card4 = new Card('Hearts', '8');
        $card5 = new Card('Hearts', '7');

        $hand = [$card1, $card2, $card3, $card4, $card5];

        $scoreAm = $evaluator->evaluateHand($hand, 'american');
        $scoreBr = $evaluator->evaluateHand($hand, 'british');

        $this->assertEquals(75, $scoreAm);
        $this->assertEquals(30, $scoreBr, );
    }


    /**
     * test if Royal Flush
     *
     * @return void
     */
    public function testRoyalFlush()
    {

        $evaluator = new HandEvaluator();

        $card1 = new Card('Hearts', 'A');
        $card2 = new Card('Hearts', '10');
        $card3 = new Card('Hearts', 'J');
        $card4 = new Card('Hearts', 'K');
        $card5 = new Card('Hearts', 'Q');

        $hand = [$card1, $card2, $card3, $card4, $card5];

        $scoreAm = $evaluator->evaluateHand($hand, 'american');
        $scoreBr = $evaluator->evaluateHand($hand, 'british');

        $this->assertEquals(100, $scoreAm);
        $this->assertEquals(30, $scoreBr, );
    }


    /**
     * test if no score in hand
     *
     * @return void
     */
    public function testNoScore()
    {

        $evaluator = new HandEvaluator();

        $card1 = new Card('Hearts', '10');
        $card2 = new Card('Spades', '4');
        $card3 = new Card('Diamonds', '2');
        $card4 = new Card('Hearts', '9');
        $card5 = new Card('Hearts', 'A');

        $hand = [$card1, $card2, $card3, $card4, $card5];

        $scoreAm = $evaluator->evaluateHand($hand, 'american');
        $scoreBr = $evaluator->evaluateHand($hand, 'british');

        $this->assertEquals(0, $scoreAm);
        $this->assertEquals(0, $scoreBr, );
    }
}

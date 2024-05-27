<?php

namespace App\PokerSquares;
use App\Card\Card;

class HandEvaluator
{
    /**
     * Evaluate score of card hand
     *
     * @param array $hand
     * @return integer
     */
    public function evaluateHand(array $hand): int
    {

        /* $hand = [];
        $hand[] = new Card('Hearts', '10');
        $hand[] = new Card('Hearts', '10');
        $hand[] = new Card('Spades', 'K');
        $hand[] = new Card('Hearts', '3');
        $hand[] = new Card('Hearts', 'J'); */

         // Assuming $cards is an array of 5 cards
         if (count($hand) !== 5) {
            throw new \InvalidArgumentException('En pokerhand måste ha exakt 5 kort.');
        }

        // Sort cards by score
        $hand = $this->sortHand($hand);


        // Get ranks and suits
        $ranks = array_map(fn(Card $card) => $card->getValue(), $hand);
        $suits = array_map(fn(Card $card) => $card->getSuit(), $hand);

        //var_dump($ranks);
        //var_dump($suits);


        if ($this->isRoyalFlush($suits, $ranks)) {
            return 100;
        }
        if ($this->isStraightFlush($suits, $ranks)) {
            return 75;
        }
        if ($this->isFourOfAKind($ranks)) {
            return 50;
        }
        if ($this->isFullHouse($ranks)) {
            return 25;
        }
        if ($this->isFlush($suits)) {
            return 20;
        }
        if ($this->isStraight($ranks)) {
            return 15;
        }
        if ($this->isThreeOfAKind($ranks)) {
            return 10;
        }
        if ($this->isTwoPairs($ranks)) {
            return 5;
        }
        if ($this->isOnePair($ranks)) {
            return 2;
        }

        return 0;
    }

    /**
     * Sort hand by score
     *
     * @param array $hand
     * @return array
     */
    private function sortHand($hand) : array {

        usort($hand, function($a, $b) {
            // Set Ace to 14 when sorting
            $valA = $a->getValue() === 'A' ? 14 : $a->getScore();
            $valB = $b->getValue() === 'A' ? 14 : $b->getScore();

            return $valA - $valB;
        });

        return $hand;
    }

    /**
     * Check if all cards in hand are of same suit
     *
     * @param array $hand
     * @return boolean
     */
    private function isSameSuit(array $suits) : bool {

        $firstSuit = $suits[0];
        foreach ($suits as $suit) {
            if ($suit !== $firstSuit) {
                return false;
            }
        }
        return true;
    }


    /**
     * Check if royal flush
     *
     * @param [type] $hand
     * @return boolean
     */
    private function isRoyalFlush($suits, $ranks) : bool {
        if ($this->isSameSuit($suits)) {

            $requiredValues = ['A', 'K', 'Q', 'J', '10'];

            // Check that all required values exists in hand
            foreach ($ranks as $rank) {
                if (!in_array($rank, $requiredValues, true)) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Check if straight flush
     *
     * @param array $hand
     * @return boolean
     */
    private function isStraightFlush($suits, $ranks) : bool {

        if ($this->isSameSuit($suits)) {
            return $this->isStraight($ranks);
        }

        return false;
    }


    /**
     * Check id flush
     *
     * @param array $hand
     * @return boolean
     */
    private function isStraight($ranks) : bool {

        $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];

        for ($i = 0; $i< count($ranks)-1; $i++) {
            $currentValueIndex = array_search($ranks[$i], $values);
            $nextValueIndex = array_search($ranks[$i+1], $values);

            if ($nextValueIndex !== $currentValueIndex + 1) {
                return false;
            }
        }

        return true;
    }

    /**
     * check if four of a kind
     *
     * @param array $ranks
     * @return boolean
     */
    private function isFourOfAKind($ranks) : bool {

        $fourOfSame = max(array_count_values($ranks)) === 4;
        return $fourOfSame;
    }


    /**
     * Check if three if a kind
     *
     * @param array $ranks
     * @return boolean
     */
    private function isThreeOfAKind($ranks) : bool {

        $fourOfSame = max(array_count_values($ranks)) === 3;
        return $fourOfSame;
    }


    /**
     * check if full house
     *
     * @param array $ranks
     * @return boolean
     */
    private function isFullHouse($ranks) {

        // There shall be 2 unique values
        $numUnique = count(array_unique($ranks));
        $maxOfSame = max(array_count_values($ranks));

        return $numUnique === 2 && $maxOfSame === 3;

    }

    /**
     * chech if flush
     *
     * @param array $suits
     * @return boolean
     */
    private function isFlush($suits) {

        // Check if all is same suit
        $numUnique = count(array_unique($suits));
        return $numUnique === 1;
    }


    /**
     * check if two pairs
     *
     * @param array $ranks
     * @return boolean
     */
    private function isTwoPairs($ranks) {

        // Number unique values
        $numUnique = count(array_unique($ranks));

        // Number of each value
        $arrayCount = array_count_values($ranks);

        return $numUnique === 3 && max($arrayCount) === 2;
    }


    /**
     * check if one pair
     *
     * @param array $ranks
     * @return boolean
     */
    private function isOnePair($ranks) {

        // Number of each value
        $arrayCount = array_count_values($ranks);

        return max($arrayCount) === 2;
    }

}

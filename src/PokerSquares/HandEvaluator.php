<?php

namespace App\PokerSquares;

use App\Card\Card;

/**
 * Class to evaluate poker hand score
 */
class HandEvaluator
{
    /**
     * List of scores for american/british scoring
     *
     * @var array<string, array<int,int>>
     */
    private array $scoring = [
        'RoyalFlush' => [100, 30],
        'StraightFlush' => [75, 30],
        'FourOfAKind' => [50, 16],
        'FullHouse' => [25, 10],
        'Flush' => [20, 5],
        'Straight' => [15, 12],
        'ThreeOfAKind' => [10, 6],
        'TwoPairs' => [5, 3],
        'OnePair' => [2, 1],
    ];

    /**
     * Evaluate score of card hand
     *
     * @param array<Card> $hand
     * @param string $scoringSystem
     * @return integer
     */
    public function evaluateHand(array $hand, $scoringSystem): int
    {
        /* $hand = [];
        $hand[] = new Card('Hearts', '10');
        $hand[] = new Card('Hearts', '8');
        $hand[] = new Card('Hearts', '9');
        $hand[] = new Card('Hearts', '7');
        $hand[] = new Card('Hearts', 'J');
 */
        $scoringIndex = $scoringSystem === 'american' ? 0 : 1;

        // Sort cards by score
        $hand = $this->sortHand($hand);

        //var_dump($hand);

        // Get ranks and suits
        $ranks = array_map(fn (Card $card) => $card->getValue(), $hand);
        $suits = array_map(fn (Card $card) => $card->getSuit(), $hand);

        $handType = '';

        if ($this->isRoyalFlush($suits, $ranks)) {
            return $this->scoring['RoyalFlush'][$scoringIndex];
        }
        if ($this->isStraightFlush($suits, $ranks)) {
            return $this->scoring['StraightFlush'][$scoringIndex];
        }
        if ($this->isFourOfAKind($ranks)) {
            return $this->scoring['FourOfAKind'][$scoringIndex];
        }
        if ($this->isFullHouse($ranks)) {
            return $this->scoring['FullHouse'][$scoringIndex];
        }
        if ($this->isFlush($suits)) {
            return $this->scoring['Flush'][$scoringIndex];
        }
        if ($this->isStraight($ranks)) {
            return $this->scoring['Straight'][$scoringIndex];
        }
        if ($this->isThreeOfAKind($ranks)) {
            return $this->scoring['ThreeOfAKind'][$scoringIndex];
        }
        if ($this->isTwoPairs($ranks)) {
            return $this->scoring['TwoPairs'][$scoringIndex];
        }
        if ($this->isOnePair($ranks)) {
            return $this->scoring['OnePair'][$scoringIndex];
        }

        return 0;
    }



    /**
     * Sort hand by score
     *
     * @param array<Card> $hand
     * @return array<Card>
     */
    private function sortHand($hand): array
    {
        usort($hand, function ($first, $second) {
            // Set Ace to 14 when sorting
            $valA = $first->getValue() === 'A' ? 14 : $first->getScore();
            $valB = $second->getValue() === 'A' ? 14 : $second->getScore();

            return $valA - $valB;
        });

        return $hand;
    }



    /**
     * Check if all cards in hand are of same suit
     *
     * @param array<string> $suits
     * @return boolean
     */
    private function isSameSuit(array $suits): bool
    {

        $firstSuit = $suits[0];
        foreach ($suits as $suit) {
            if ($suit !== $firstSuit) {
                return false;
            }
        }
        return true;
    }


    /**
     * check if royal flush
     *
     * @param array<string> $suits
     * @param array<string> $ranks
     * @return boolean
     */
    private function isRoyalFlush($suits, $ranks): bool
    {
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
     * @param array<string> $suits
     * @param array<string> $ranks
     * @return boolean
     */
    private function isStraightFlush($suits, $ranks): bool
    {
        if ($this->isSameSuit($suits)) {
            return $this->isStraight($ranks);
        }

        return false;
    }


    /**
     * Check id flush
     *
     * @param array<string> $ranks
     * @return boolean
     */
    private function isStraight($ranks): bool
    {
        $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];

        for ($i = 0; $i < 4; $i++) {
            $currentValueIndex = array_search($ranks[$i], $values);
            $nextValueIndex = array_search($ranks[$i + 1], $values);

            if ($nextValueIndex !== $currentValueIndex + 1) {
                return false;
            }
        }

        return true;
    }

    /**
     * check if four of a kind
     *
     * @param array<string> $ranks
     * @return boolean
     */
    private function isFourOfAKind($ranks): bool
    {

        $fourOfSame = max(array_count_values($ranks)) === 4;
        return $fourOfSame;
    }


    /**
     * Check if three if a kind
     *
     * @param array<string> $ranks
     * @return boolean
     */
    private function isThreeOfAKind($ranks): bool
    {

        $fourOfSame = max(array_count_values($ranks)) === 3;
        return $fourOfSame;
    }


    /**
     * check if full house
     *
     * @param array<string> $ranks
     * @return boolean
     */
    private function isFullHouse($ranks): bool
    {

        // There shall be 2 unique values
        $numUnique = count(array_unique($ranks));
        $maxOfSame = max(array_count_values($ranks));

        return $numUnique === 2 && $maxOfSame === 3;

    }

    /**
     * chech if flush
     *
     * @param array<string> $suits
     * @return boolean
     */
    private function isFlush($suits): bool
    {

        // Check if all is same suit
        $numUnique = count(array_unique($suits));
        return $numUnique === 1;
    }


    /**
     * check if two pairs
     *
     * @param array<string> $ranks
     * @return boolean
     */
    private function isTwoPairs(array $ranks): bool
    {

        // Number unique values
        $numUnique = count(array_unique($ranks));

        // Number of each value
        $arrayCount = array_count_values($ranks);

        return $numUnique === 3 && max($arrayCount) === 2;
    }


    /**
     * check if one pair
     *
     * @param array<string> $ranks
     * @return boolean
     */
    private function isOnePair(array $ranks): bool
    {

        // Number of each value
        $arrayCount = array_count_values($ranks);

        return max($arrayCount) === 2;
    }

}

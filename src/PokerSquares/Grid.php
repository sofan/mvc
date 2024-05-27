<?php

namespace App\PokerSquares;

use App\Card\Card;

/**
 * Grid board for poker squares
 */
class Grid
{
    /**
     * Poker square grid
     *
     * @var array<int, array<int, Card|null>>
     */
    private array $grid;

    private int $numRows = 5;
    private int $numCols = 5;
    public function __construct()
    {
        $this->grid = array_fill(0, $this->numRows, array_fill(0, $this->numCols, null));
    }

    /**
     * Place card in grid
     *
     * @param integer $row
     * @param integer $col
     * @param Card $card
     * @return boolean
     */
    public function placeCard(int $row, int $col, Card $card): bool
    {
        if ($this->grid[$row][$col] === null) {
            $this->grid[$row][$col] = $card;
            return true;
        }
        return false;
    }


    /**
     * Get number of grid rows
     *
     * @return int
     */
    public function getNumRows(): int
    {
        return $this->numRows;
    }

    /**
     * Get number of columns in grid
     *
     * @return int
     */
    public function getNumCols(): int
    {
        return $this->numCols;
    }

    /**
     * Get grid
     *
     * @return array<int, array<int, Card|null>>
     */
    public function getGrid(): array
    {
        return $this->grid;
    }



    /**
     * Get grid row if hand is full, otherwise null
     *
     * @param int $index
     * @return array<Card>|null
     */
    public function getRowIfFullHand($index)
    {

        // Makte sure index is in correct interval
        if ($index < 0 || $index >= $this->numRows) {
            return null;
        }

        // Check that filtered number of rows in hand is correct
        $row = array_filter($this->grid[$index]);
        if (count($row) === $this->numRows) {
            return $row;
        }

        return null;
    }


    /**
     * Get grid column if full hand
     *
     * @param int $index
     * @return array<Card>|null
     */
    public function getColumnIfFullHand($index)
    {

        // Makte sure index is in correct interval
        if ($index < 0 || $index >= $this->numCols) {
            return null;
        }

        $col = array_filter(array_column($this->grid, $index));

        if (count($col) === $this->numCols) {
            return $col;
        }

        return null;

    }


    public function getNumEmptyCells(): int
    {

        $emptyCells = 0;

        foreach ($this->grid as $row) {
            foreach ($row as $col) {
                if ($col === null) {
                    $emptyCells++;
                }
            }
        }
        return $emptyCells;
    }


    /**
     * Calculate scores in grid rows and colums
     *
     * @param HandEvaluator $evaluator
     * @param string $scoringSystem
     * @return array
     */
    public function calculateScores(HandEvaluator $evaluator, string $scoringSystem): array
    {
        $scores = [
            'rows' => [],
            'cols' => [],
            'total' => 0
        ];

        // Get row scores if row is a full hand
        for ($i = 0; $i < 5; $i++) {
            $hand = $this->getRowIfFullHand($i);
            $scores['rows'][$i] = null;
            if ($hand) {
                $scores['rows'][$i] = $evaluator->evaluateHand($hand, $scoringSystem);
            }
        }

        // Get column scores if column is a full hand
        for ($i = 0; $i < 5; $i++) {
            $hand = $this->getColumnIfFullHand($i);
            $scores['cols'][$i] = null;
            if ($hand) {
                $scores['cols'][$i] = $evaluator->evaluateHand($hand, $scoringSystem);
            }
        }

        $scores['total'] = array_sum($scores['rows']) + array_sum($scores['cols']);
        return $scores;
    }



    /**
     * Get grid with card information
     *
     * @return array<int<0, max>, array<string, array<int<0, max>, string|null>|int<0, max>>>
     */
    public function getGridJson(): array
    {
        $gridWithCards = [];

        $rowNumber = 0;
        foreach ($this->grid as $row) {
            $cardsInRow = [];
            foreach ($row as $col) {
                $cardsInRow[] = $col instanceof Card ? $col->getAsString() : null;

            }
            $gridWithCards[] = [
                'row' => $rowNumber,
                'cards' => $cardsInRow
            ];
            $rowNumber++;
        }

        return $gridWithCards;
    }



}

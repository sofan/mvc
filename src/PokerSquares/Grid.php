<?php

namespace App\PokerSquares;

use App\Card\Card;

class Grid
{
    private array $grid;

    public function __construct()
    {
        $this->grid = array_fill(0, 5, array_fill(0, 5, null));
    }

    public function placeCard(int $row, int $col, Card $card): bool
    {
        if ($this->grid[$row][$col] === null) {
            $this->grid[$row][$col] = $card;
            return true;
        }
        return false;
    }

    public function getGrid(): array
    {
        return $this->grid;
    }


    public function getNumEmptyCells() : int {

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
}


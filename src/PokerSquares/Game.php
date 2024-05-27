<?php

namespace App\PokerSquares;

use App\Card\CardGraphic;
use App\Card\DeckOfCards;
use App\Card\Card;

class Game
{
    private DeckOfCards $deck;
    private Grid $grid;
    private HandEvaluator $evaluator;

    private ?CardGraphic $currentCard;

    public function __construct()
    {
        $this->deck = new DeckOfCards();
        $this->currentCard = null;
        $this->grid = new Grid();
        $this->evaluator = new HandEvaluator();

    }

    public function drawCard(): ?CardGraphic
    {
        if ($this->currentCard === null && $this->deck->getNumberOfCards() > 0) {
            $drawnCards = $this->deck->draw(1);
            $this->currentCard = $drawnCards[0];
        }
        return $this->currentCard;
    }

    public function placeCard(int $row, int $col): bool
    {
        if ($this->currentCard !== null) {
            $placed = $this->grid->placeCard($row, $col, $this->currentCard);
            if ($placed) {
                $this->currentCard = null;
                return true;
            }
        }
        return false;
    }

    public function getCurrentCard(): ?Card
    {
        return $this->currentCard;
    }

    public function calculateScores(): array
    {
        $scores = [
            'rows' => [],
            'cols' => [],
            'total' => 0
        ];

        $grid = $this->grid->getGrid();

        // Get row scores if row is a full hand
        for ($i=0; $i<5; $i++) {
            $row = $grid[$i];
            if ($this->isFullHand($row)) {
                $scores['rows'][$i] = $this->evaluator->evaluateHand($row);
            }
            else {
                $scores['rows'][$i] = null;
            }
        }


        // Get column scores if column is a full hand
        for ($i=0; $i<5; $i++) {
            $col = array_column($grid, $i);
            if ($this->isFullHand($col)) {
                $scores['cols'][$i] = $this->evaluator->evaluateHand($col);
            }
            else {
                $scores['cols'][$i] = null;
            }
        }

        $scores['total'] = array_sum($scores['rows']) + array_sum($scores['cols']);

        return $scores;
    }

    private function isFullHand(array $hand): bool
    {

        foreach ($hand as $card) {
            if ($card === null) {
                return false;
            }
        }
        return true;
    }

    private function calculateHandScore($values) : ?int {

        $sum = 0;
        foreach ($values as $val) {
            $sum += $val->getScore();
        }
        return $sum;
    }

    public function getGrid(): array
    {
        return $this->grid->getGrid();
    }

    public function getEmptyCells() : int {
        return $this->grid->getNumEmptyCells();
    }



}

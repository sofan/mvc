<?php

namespace App\PokerSquares;

use App\Card\DeckOfCards;
use App\Card\Card;

/**
 * Square Game Class
 */
class Game
{
    public const SCORING_AMERICAN = 'american';
    public const SCORING_BRITISH = 'british';

    /**
     * Deck of Cards
     *
     * @var DeckOfCards
     */
    private DeckOfCards $deck;

    /**
     * Game grid to place cards
     *
     * @var Grid
     */
    private Grid $grid;

    /**
     * Hand evaluator to calculate scores
     *
     * @var HandEvaluator
     */
    private HandEvaluator $evaluator;

    /**
     * Current card to place
     *
     * @var Card|null
     */
    private ?Card $currentCard;

    /**
     * player name
     *
     * @var string
     */
    private string $playerName;

    /**
     * scoring system to use
     *
     * @var string
     */
    private string $scoringSystem;

    /**
     * Game constructor
     *
     * @param string $playerName
     * @param string $scoringSystem
     */
    public function __construct(string $playerName, string $scoringSystem = self::SCORING_AMERICAN)
    {
        $this->deck = new DeckOfCards();
        $this->deck->fill();
        $this->deck->shuffle();
        $this->currentCard = null;
        $this->grid = new Grid();
        $this->evaluator = new HandEvaluator();
        $this->playerName = $playerName;
        $this->scoringSystem = $scoringSystem;
    }

    /**
     * Draw card
     *
     * @return Card|null
     */
    public function drawCard(): ?Card
    {
        if ($this->currentCard === null && $this->deck->getNumberOfCards() > 0) {
            $drawnCards = $this->deck->draw(1);
            $this->currentCard = $drawnCards[0];
        }
        return $this->currentCard;
    }

    /**
     * Place card on grid
     *
     * @param integer $row
     * @param integer $col
     * @return boolean
     */
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

    /**
     * Get current card
     *
     * @return Card|null
     */
    public function getCurrentCard(): ?Card
    {
        return $this->currentCard;
    }


    /**
     * Get Scoring system (american or brittish)
     *
     * @return string
     */
    public function getScoringSystem(): string
    {
        return $this->scoringSystem;
    }

    /**
     * Set scoring system
     *
     * @param string $scoring
     * @return void
     */
    public function setScoringSystem($scoring): void
    {
        $this->scoringSystem = $scoring;
    }

    /**
     * Get player name
     *
     * @return string
     */
    public function getPlayerName(): string
    {
        return $this->playerName;
    }


    /**
     * Calculate score for game board
     *
     * @return array<string, array<int, int|null>|int>
     */
    public function calculateScores(): array
    {
        return $this->grid->calculateScores($this->evaluator, $this->scoringSystem);
    }



    /**
     * Get game grid
     *
     * @return array<int, array<int, Card|null>>
     */
    public function getGrid(): array
    {
        return $this->grid->getGrid();
    }

    /**
     * Get grid as json string
     *
     * @return array<int<0, max>, array<string, array<int<0, max>, string|null>|int<0, max>>>
     */
    public function getJsonGrid(): array
    {
        return $this->grid->getGridJson();
    }

    /**
     * Check if there are cards left to place on grid
     *
     * @return integer
     */
    public function getEmptyCells(): int
    {
        return $this->grid->getNumEmptyCells();
    }

}

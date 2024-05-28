<?php

namespace App\PokerSquares;

use App\Card\Card;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class PokerSquares\Game
 */
class SquareGameTest extends TestCase
{
    /**
     * test constructor and getCards function
     *
     * @return void
     */
    public function testCreateEmptyDeckOfCards()
    {
        $game = new Game('player1');

        // Assert
        $this->assertIsArray($game->getGrid());
        $this->assertEquals(25, $game->getEmptyCells());
        $this->assertEquals('player1', $game->getPlayerName());
    }


    /**
     * test draw card
     *
     * @return void
     */
    public function testDrawCard()
    {

        $game = new Game('player1');

        $card = $game->drawCard();

        $this->assertInstanceOf("\App\Card\CardGraphic", $card);

        $currCard = $game->getCurrentCard();

        $this->assertNotNull($currCard);
    }


    /**
     * test place card without draw card first
     *
     * @return void
     */
    public function testPlaceCardWithoutDraw()
    {

        $game = new Game('player1');

        $placed = $game->placeCard(1, 3);

        $this->assertFalse($placed);
    }


    /**
     * test place card
     *
     * @return void
     */
    public function testPlaceCard()
    {

        $game = new Game('player1');

        $card = $game->drawCard();
        $currentCard = $game->getCurrentCard();

        $this->assertEquals($card, $currentCard);

        $placed = $game->placeCard(1, 3);

        $this->assertTrue($placed);
    }



    /**
     * Test get current card
     *
     * @return void
     */
    public function testGetCurrentCard()
    {

        $game = new Game('player1');
        $card = $game->getCurrentCard();

        $this->assertNull($card);
    }


    /**
     * Test get scoring system
     *
     * @return void
     */
    public function testGetScoring()
    {

        $game = new Game('player1', "american");
        $scoring = $game->getScoringSystem();

        $this->assertEquals($scoring, "american");
    }


    /**
     * Test set scoring system
     *
     * @return void
     */
    public function testSetScoring()
    {

        $game = new Game('player1', "american");
        $game->setScoringSystem('british');
        $scoring = $game->getScoringSystem();

        $this->assertEquals($scoring, "british");
    }


    /**
     * Test calculate scores for grid
     *
     * @return void
     */
    public function testCalculateScores()
    {
        // Skapa ett Game-objekt med grid och evaluator
        $game = new Game('player');

        $game->drawCard();
        $game->placeCard(0, 0);

        $result = $game->calculateScores();

        $expected = [
            'rows' => [0 => null, 1 => null, 2 => null, 3 => null, 4 => null],
            'cols' => [0 => null, 1 => null, 2 => null, 3 => null, 4 => null],
            'total' => 0
        ];

        // Jämför resultatet med det förväntade
        $this->assertEquals($expected, $result);
    }


    /**
     * Test get grid as Json
     *
     * @return void
     */
    public function testGetJsonGrid()
    {
        // Skapa ett Game-objekt med grid och evaluator
        $game = new Game('player');

        $game->drawCard();
        $game->placeCard(0, 0);

        $result = $game->getJsonGrid();


        // Jämför resultatet med det förväntade
        $this->assertCount(5, $result);
        $this->assertArrayHasKey('row', $result[0]);

    }






}

<?php

namespace App\PokerSquares;

use App\Card\Card;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Grid
 */
class GridTest extends TestCase
{
    /**
     * test place card in empty grid cell
     *
     * @return void
     */
    public function testPlaceOk()
    {
        $grid = new Grid();

        $card1 = new Card('Hearts', '3');

        $placed = $grid->placeCard(1, 1, $card1);

        // Assert
        $this->assertTrue($placed);
    }


    /**
     * test place card in occupied grid cell
     *
     * @return void
     */
    public function testPlaceNotOk()
    {
        $grid = new Grid();

        $card1 = new Card('Hearts', '3');
        $card2 = new Card('Hearts', '5');

        $placed1 = $grid->placeCard(1, 1, $card1);
        $placed2 = $grid->placeCard(1, 1, $card2);

        // Assert
        $this->assertTrue($placed1);
        $this->assertFalse($placed2);
    }

    /**
     * Test get number of rows in grid
     *
     * @return void
     */
    public function testGetNumRows()
    {
        $grid = new Grid();
        $rows = $grid->getNumRows();
        $this->assertEquals(5, $rows);
    }


    /**
     * Test get number of columns in grid
     *
     * @return void
     */
    public function testGetNumCosl()
    {
        $grid = new Grid();
        $rows = $grid->getNumCols();
        $this->assertEquals(5, $rows);
    }


    /**
     * Test get grid
     *
     * @return void
     */
    public function testGetGrid()
    {
        $grid = new Grid();

        $gridArray = $grid->getGrid();
        $this->assertIsArray($gridArray);
    }



    /**
     * Test get full row
     *
     * @return void
     */
    public function testGetRowIfFullHandOk()
    {
        $grid = new Grid();

        $card1 = new Card('Hearts', 'J');
        $card2 = new Card('Spades', '5');
        $card3 = new Card('Clubs', 'K');
        $card4 = new Card('Hearts', '2');
        $card5 = new Card('Hearts', 'A');

        // Place full row
        $grid->placeCard(0, 0, $card1);
        $grid->placeCard(0, 1, $card2);
        $grid->placeCard(0, 2, $card3);
        $grid->placeCard(0, 3, $card4);
        $grid->placeCard(0, 4, $card5);

        // Get row index 0
        $row = $grid->getRowIfFullHand(0);

        $this->assertIsArray($row);
    }


    /**
     * Test get not full row
     *
     * @return void
     */
    public function testGetRowIfFullHandNotOk()
    {
        $grid = new Grid();

        $card1 = new Card('Hearts', 'J');
        $card2 = new Card('Spades', '5');
        $card3 = new Card('Clubs', 'K');
        $card4 = new Card('Hearts', '2');

        // Place full row
        $grid->placeCard(0, 0, $card1);
        $grid->placeCard(0, 1, $card2);
        $grid->placeCard(0, 2, $card3);
        $grid->placeCard(0, 3, $card4);


        // Get row index 0
        $row = $grid->getRowIfFullHand(0);

        $this->assertNull($row);
    }


    /**
     * Test get not full row with not correct index
     *
     * @return void
     */
    public function testGetRowIfFullHandWrongIndex()
    {
        $grid = new Grid();

        $card1 = new Card('Hearts', 'J');
        $card2 = new Card('Spades', '5');
        $card3 = new Card('Clubs', 'K');
        $card4 = new Card('Hearts', '2');
        $card5 = new Card('Hearts', 'A');

        // Place full row
        $grid->placeCard(0, 0, $card1);
        $grid->placeCard(0, 1, $card2);
        $grid->placeCard(0, 2, $card3);
        $grid->placeCard(0, 3, $card4);
        $grid->placeCard(0, 4, $card5);


        // Get row index 0
        $row = $grid->getRowIfFullHand(5);

        $this->assertNull($row);
    }



    /**
     * Test get full column
     *
     * @return void
     */
    public function testGetColIfFullHandOk()
    {

        $grid = new Grid();

        $card1 = new Card('Hearts', 'J');
        $card2 = new Card('Spades', '5');
        $card3 = new Card('Clubs', 'K');
        $card4 = new Card('Hearts', '2');
        $card5 = new Card('Hearts', 'A');

        // Place full column
        $grid->placeCard(0, 0, $card1);
        $grid->placeCard(1, 0, $card2);
        $grid->placeCard(2, 0, $card3);
        $grid->placeCard(3, 0, $card4);
        $grid->placeCard(4, 0, $card5);

        // Get column index 0
        $col = $grid->getColumnIfFullHand(0);

        $this->assertIsArray($col);
    }


    /**
     * Test get not full column
     *
     * @return void
     */
    public function testGetColIfFullHandNotOk()
    {
        $grid = new Grid();

        $card1 = new Card('Hearts', 'J');
        $card2 = new Card('Spades', '5');
        $card3 = new Card('Clubs', 'K');
        $card4 = new Card('Hearts', '2');

        // Place full row
        $grid->placeCard(0, 0, $card1);
        $grid->placeCard(1, 0, $card2);
        $grid->placeCard(2, 0, $card3);
        $grid->placeCard(3, 0, $card4);

        // Get row index 0
        $col = $grid->getColumnIfFullHand(0);

        $this->assertNull($col);
    }


    /**
     * Test get not full row with not correct index
     *
     * @return void
     */
    public function testGetColIfFullHandWrongIndex()
    {
        $grid = new Grid();

        $card1 = new Card('Hearts', 'J');

        // Place full row
        $grid->placeCard(0, 0, $card1);


        // Get row index 0
        $col = $grid->getColumnIfFullHand(5);

        $this->assertNull($col);
    }


    /**
     * Test get number of empty grid cells
     *
     * @return void
     */
    public function testGetNumEmptyCells()
    {

        $grid = new Grid();

        $card1 = new Card('Hearts', 'J');

        $grid->placeCard(0, 0, $card1);

        $emptyCells = $grid->getNumEmptyCells();

        $this->assertEquals($emptyCells, 24);
    }

    /**
     * test to get grid as JSON string
     *
     * @return void
     */
    public function testGetGridJson()
    {
        $grid = new Grid();

        $card1 = new Card('Hearts', '10');
        $card2 = new Card('Spades', 'K');

        $grid->placeCard(0, 0, $card1);
        $grid->placeCard(1, 1, $card2);

        // Förväntat resultat
        $expected = [
            [
                'row' => 0,
                'cards' => ['[Hearts 10]', null, null, null, null],
            ],
            [
                'row' => 1,
                'cards' => [null, '[Spades K]', null, null, null],
            ],
            [
                'row' => 2,
                'cards' => [null, null, null, null, null],
            ],
            [
                'row' => 3,
                'cards' => [null, null, null, null, null],
            ],
            [
                'row' => 4,
                'cards' => [null, null, null, null, null],
            ],
        ];

        $result = $grid->getGridJson();

        $this->assertEquals($expected, $result);

    }


    /**
     * Test calculate score when row has full hand
     *
     * @return void
     */
    public function testCalulateScoresRow()
    {

        $grid = new Grid();
        $evaluator = new HandEvaluator();

        // Placera kort i en full hand i rad 0 (Royal Flush)
        $grid->placeCard(0, 0, new Card('Hearts', '10'));
        $grid->placeCard(0, 1, new Card('Hearts', 'J'));
        $grid->placeCard(0, 2, new Card('Hearts', 'Q'));
        $grid->placeCard(0, 3, new Card('Hearts', 'K'));
        $grid->placeCard(0, 4, new Card('Hearts', 'A'));

        // Beräkna poäng
        $result = $grid->calculateScores($evaluator, 'american');

        // Förväntat resultat
        $expected = [
            'rows' => [0 => 100, 1 => null, 2 => null, 3 => null, 4 => null],
            'cols' => [0 => null, 1 => null, 2 => null, 3 => null, 4 => null],
            'total' => 100
        ];

        $this->assertEquals($expected, $result);

    }


    /**
     * Test calculate score when column has full hand
     *
     * @return void
     */
    public function testCalulateScoresCol()
    {

        $grid = new Grid();
        $evaluator = new HandEvaluator();

        // Placera kort i en full hand i rad 0 (Royal Flush)
        $grid->placeCard(0, 1, new Card('Hearts', '10'));
        $grid->placeCard(1, 1, new Card('Hearts', 'J'));
        $grid->placeCard(2, 1, new Card('Hearts', 'Q'));
        $grid->placeCard(3, 1, new Card('Hearts', 'K'));
        $grid->placeCard(4, 1, new Card('Hearts', 'A'));

        // Beräkna poäng
        $result = $grid->calculateScores($evaluator, 'american');

        // Förväntat resultat
        $expected = [
            'rows' => [0 => null, 1 => null, 2 => null, 3 => null, 4 => null],
            'cols' => [0 => null, 1 => 100, 2 => null, 3 => null, 4 => null],
            'total' => 100
        ];

        $this->assertEquals($expected, $result);

    }



}

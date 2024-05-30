<?php

namespace App\Controller;

use App\PokerSquares\Game;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Test cases for class Poker Squares GameController
 */
class SquareGameControllerApiTest extends WebTestCase
{
    /**
     * test api start route
     *
     * @return void
     */
    public function testApiStartResponse(): void
    {
        $client = static::createClient();

        $client->request('GET', '/proj/api');

        $this->assertResponseIsSuccessful();

        // Check some content in the twig template
        $this->assertSelectorTextContains('h1', 'API');

    }

    /**
     * Test API for game start
     *
     * @return void
     */
    public function testApiStartJson(): void
    {

        // Createa stub for SessionInterface class.
        $sessionStub = $this->createMock(SessionInterface::class);

        // Create GameControllerJson.
        $controller = new ProjectControllerApi();

        // Förväntade data baserat på ett spel i sessionen.
        $exp = [
            'poker_squares' => [
                'player' => [
                    'name' => 'testPlayer',
                    'scoringSystem' => 'american'
                ],
                'board' => []            ]
        ];

        $sessionStub->method('has')
        ->with('square_game')
        ->willReturn(true);

        $sessionStub->method('get')
            ->with('square_game')
            ->willReturn(new PokerSquareTestGame('testPlayer'));


        // Get JSON response from session stub
        $response = $controller->apiGame($sessionStub);

        // Assert that respone is JSON
        $this->assertInstanceOf(JsonResponse::class, $response);

        // Get json content and check that it is a string
        $content = $response->getContent();
        $this->assertIsString($content);

        if ($content !== '') {
            // Get content and json decode
            $res = json_decode($content, true);
            $this->assertEquals($exp, $res);
        }
    }


    /**
     * test api game
     *
     * @return void
     */
    public function testApiGame(): void
    {
        $client = static::createClient();

        $client->request('GET', '/proj/api/game');

        $response = $client->getResponse();

        // Check that response is a JSON
        $this->assertInstanceOf(JsonResponse::class, $response);

    }



    /**
     * test api score
     *
     * @return void
     */
    public function testApiScore(): void
    {
        $client = static::createClient();

        $client->request('GET', '/proj/api/score');

        $response = $client->getResponse();

        // Check that response is a JSON
        $this->assertInstanceOf(JsonResponse::class, $response);
    }




    /**
     * test api player
     *
     * @return void
     */
    public function testApiPlayer(): void
    {
        $client = static::createClient();

        $client->request('GET', '/proj/api/player');

        $response = $client->getResponse();

        // Check that response is a JSON
        $this->assertInstanceOf(JsonResponse::class, $response);
    }


    /**
     * test api empty cells
     *
     * @return void
     */
    public function testApiCells(): void
    {
        $client = static::createClient();

        $client->request('GET', '/proj/api/cells');

        $response = $client->getResponse();

        // Check that response is a JSON
        $this->assertInstanceOf(JsonResponse::class, $response);
    }


    /**
     * test api scoring system
     *
     * @return void
     */
    public function testApiScoring(): void
    {
        $client = static::createClient();

        $client->request('POST', '/proj/api/system');

        $response = $client->getResponse();

        // Check that response is a JSON
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

}


/**
 * TestGame class to use in test, extends Game class
 */
class PokerSquareTestGame extends Game
{
    public function __construct($playerName)
    {
        parent::__construct($playerName);
    }

    public function getPlayerName(): string
    {
        return 'testPlayer';
    }

    public function getScoringSystem(): string
    {
        return 'american';
    }

    public function getJsonGrid(): array
    {
        return [];
    }

}

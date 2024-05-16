<?php

namespace App\Controller;

use App\Card\Card;
use App\Game\Dealer;
use App\Game\Game;
use App\Game\Player;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Test cases for class GameControllerJson
 */
class GameControllerJsonTest extends TestCase
{
    public function testApiGameReturnsJsonResponse(): void
    {
        // Createa stub for SessionInterface class.
        $sessionStub = $this->createMock(SessionInterface::class);

        // Create GameControllerJson.
        $controller = new GameControllerJson();

        // Förväntade data baserat på ett spel i sessionen.
        $exp = [
            'game' => [
                'player' => [
                    'score' => 21,
                    'money' => 100,
                    'hand' => ['cards' => [['suit' => 'Hearts', 'value' => 'A'], ['suit' => 'Spades', 'value' => '10']]]
                ],
                'dealer' => [
                    'score' => 25,
                    'money' => 100,
                    'hand' => ['cards' => [['suit' => 'Clubs', 'value' => 'K'], ['suit' => 'Diamonds', 'value' => 'Q']]]
                ]
            ]
        ];

        // Konfigurera mocken för SessionInterface för att returnera ett testspel.
        $sessionStub->method('get')->willReturn(new TestGame());

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


}


/**
 * TestGame class to use in test, extends Game class
 */
class TestGame extends Game
{
    public function getPlayer(): Player
    {
        $player = new Player('Player', 100);

        $player->addCard(new Card('Hearts', 'A'));
        $player->addCard(new Card('Spades', '10'));
        return $player;
    }

    public function getDealer(): Dealer
    {
        $dealer = new Dealer(100);

        $dealer->addCard(new Card('Clubs', 'K'));
        $dealer->addCard(new Card('Diamonds', 'Q'));
        return $dealer;
    }
}

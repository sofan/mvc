<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\DeckOfCards;
use App\Game\Dealer;
use App\Game\Game;
use App\Game\Player;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Test cases for class GameControllerJson
 */
class CardControllerJsonTest extends TestCase
{
    public function testApiDeck()
    {
        // Create SessionInterface stub
        $sessionStub = $this->createMock(SessionInterface::class);

        // Mock DeckOfCards
        $deckOfCards = $this->createMock(DeckOfCards::class);
        $cardArray = [
            ['suit' => 'hearts', 'value' => 'A'],
            ['suit' => 'hearts', 'value' => '2']
        ];

        // Set expected result
        $deckOfCards->method('getCardArray')->willReturn($cardArray);
        $sessionStub->expects($this->once())
                ->method('set')
                ->with($this->equalTo('deck'), $this->equalTo($deckOfCards));

        // Skapa en instans av CardController och mocka createDeckOfCards metoden
        $controller = $this->getMockBuilder(CardControllerJson::class)
                           ->onlyMethods(['createDeckOfCards'])
                           ->getMock();
        $controller->method('createDeckOfCards')->willReturn($deckOfCards);

        // Get apiDeck
        $response = $controller->apiDeck($sessionStub);

        // Check JsonResponse
        $this->assertInstanceOf(JsonResponse::class, $response);

        // Check JSON data
        $expectedData = [
            'deckOfCards' => $cardArray,
        ];

        $this->assertJsonStringEqualsJsonString(
            json_encode($expectedData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            $response->getContent()
        );
    }

}

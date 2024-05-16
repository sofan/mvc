<?php

namespace App\Controller;


use App\Card\CardGraphic;
use App\Card\DeckOfCards;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Test cases for class GameControllerJson
 */
class CardControllerJsonTest extends WebTestCase
{
    /**
     * Test API for apiDeck
     *
     * @return void
     */
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
        $exp = [
            'deckOfCards' => $cardArray,
        ];

        $content = $response->getContent();

        if ($content !== false && $content !== '') {
            $expectedJson = json_encode($exp, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            $this->assertIsString($expectedJson, "json_encode failed to encode expected data");
            $this->assertJsonStringEqualsJsonString(
                $expectedJson,
                $content
            );
        }

    }

    /**
     * test route /api/deck/shuffle
     *
     * @return void
     */
    public function testDeckShufflePost() {

        $client = static::createClient();

        // Send POST request
        $client->request('POST', '/api/deck/shuffle');

        // Get response
        $response = $client->getResponse();

        // Check that response is a redirect
        $this->assertTrue($response->isRedirect());

        // Check that rout is correct
        $this->assertEquals('/api/deck/shuffle', $response->headers->get('Location'));

    }


    public function testApiDeckShuffleGet()
    {
        // Skapa en klient för att simulera en webbläsare
        $client = static::createClient();

        // Skicka en GET-begäran till den angivna routen
        $client->request('GET', '/api/deck/shuffle');

        // Få responsen
        $response = $client->getResponse();

        // Kontrollera att responsen är en JsonResponse
        $this->assertInstanceOf(JsonResponse::class, $response);

        // Kontrollera att responsen har statuskod 200
        $this->assertEquals(200, $response->getStatusCode());

        // Hämta och dekoda JSON-innehållet
        $content = $response->getContent();
        $data = json_decode($content, true);

        // Kontrollera att JSON-innehållet innehåller en kortlek med 52 kort
        $this->assertArrayHasKey('deckOfCards', $data);
        $this->assertCount(52, $data['deckOfCards']);
    }



}

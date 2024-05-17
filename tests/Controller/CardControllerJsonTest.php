<?php

namespace App\Controller;

use App\Card\DeckOfCards;

use App\Service\DeckService;
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

        // Mock DeckService
        $deckService = $this->createMock(DeckService::class);

        // Mock DeckOfCards
        $deckOfCards = $this->createMock(DeckOfCards::class);
        $cardArray = [
            ['suit' => 'hearts', 'value' => 'A'],
            ['suit' => 'hearts', 'value' => '2']
        ];

        // Set expected result
        $deckService->method('createDeckOfCards')->willReturn($deckOfCards);
        $deckOfCards->method('getCardArray')->willReturn($cardArray);

        $sessionStub->expects($this->once())
                ->method('set')
                ->with($this->equalTo('deck'), $this->equalTo($deckOfCards));

        // Skapa en instans av CardControllerJson och mocka createDeckOfCards metoden
        $controller = new CardControllerJson($deckService);

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
    public function testDeckShufflePost()
    {

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


    /**
     * test apiDeckShuffleGet
     *
     * @return void
     */
    public function testapiDeckDrawPost(): void
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
        $this->assertIsString($content);

        if ($content !== '') {
            $data = json_decode($content, true);
            $this->assertIsArray($data);

            // Kontrollera att JSON-innehållet innehåller en kortlek med 52 kort
            $this->assertArrayHasKey('deckOfCards', $data);
        }

    }


    /**
     * test GET route /api/deck/shuffle
     *
     * @return void
     */
    public function testDeckShuffleGet()
    {

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


    /**
     * Test draw card POST
     *
     * @return void
     */
    public function testDrawPost()
    {

        $client = static::createClient();

        // Send POST request
        $client->request('POST', '/api/deck/draw');

        // Get response
        $response = $client->getResponse();

        // Check that response is a redirect
        $this->assertTrue($response->isRedirect());

        // Check that rout is correct
        $this->assertEquals('/api/deck/draw/1', $response->headers->get('Location'));
    }


    /**
     * test draw number of cards POST
     *
     * @return void
     */
    public function testDrawNumPost()
    {

        $client = static::createClient();

        $numCards = 3;

        // Skicka en POST till routen med rätt antal kort
        $client->request('POST', '/api/deck/draw/' . $numCards, ['num_cards' => $numCards]);

        // Get response
        $response = $client->getResponse();

        // Check that response is a redirect
        $this->assertTrue($response->isRedirect());

        // Check that rout is correct
        $this->assertEquals('/api/deck/draw/3', $response->headers->get('Location'));
    }



    /**
     * test draw number of cards POST
     *
     * @return void
     */
    public function testDrawNumGet()
    {

        $client = static::createClient();

        $numCards = 3;

        // Skicka en POST till routen med rätt antal kort
        $client->request('GET', '/api/deck/draw/' . $numCards);

        // Get response
        $response = $client->getResponse();

        // Check that response is a JSON
        $this->assertInstanceOf(JsonResponse::class, $response);

        $this->assertEquals(200, $response->getStatusCode());

    }


    /**
     * test card hand POST
     *
     * @return void
     */
    public function testApiCardHandPost()
    {

        $client = static::createClient();

        // Skicka en POST till routen med rätt antal kort
        $client->request('POST', '/api/deck/deal/2/3');

        // Get response
        $response = $client->getResponse();

        // Check that response is a redirect
        $this->assertTrue($response->isRedirect());

        // Check that rout is correct
        $this->assertEquals('/api/deck/deal/0/0', $response->headers->get('Location'));
    }



    /**
     * test card hand GET
     *
     * @return void
     */
    public function testCardHandGet()
    {

        $client = static::createClient();

        $numPlayers = 2;
        $numCards = 5;

        // Skicka en POST till routen med rätt antal kort
        $client->request('GET', '/api/deck/deal/' . $numPlayers . '/' . $numCards);

        // Get response
        $response = $client->getResponse();

        // Check that response is a JSON
        $this->assertInstanceOf(JsonResponse::class, $response);

        $this->assertEquals(200, $response->getStatusCode());

    }






}

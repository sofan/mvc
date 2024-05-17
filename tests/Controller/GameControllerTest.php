<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test cases for class GameController
 */
class GameControllerTest extends WebTestCase
{
    /**
     * test game_start route
     *
     * @return void
     */
    public function testGameStart(): void
    {
        $client = static::createClient();

        $client->request('GET', '/game');

        $this->assertResponseIsSuccessful();

        // Check some content in the twig template
        $this->assertSelectorTextContains('h1', '21 startsida');

    }


    /**
     * test doc route
     *
     * @return void
     */
    public function testDocRoute(): void
    {
        $client = static::createClient();

        $client->request('GET', '/game/doc');

        $this->assertResponseIsSuccessful();

        // Check some content in the twig template
        $this->assertSelectorTextContains('h2', 'Flödesschema');
    }


    public function testGameDraw() {

        $client = static::createClient();

        // Send request
        $client->request('GET', '/game/draw');

        // Get response
        $response = $client->getResponse();

        // Check that response is a redirect
        $this->assertTrue($response->isRedirect());

        // Check that route is correct
        $this->assertEquals('/game/play', $response->headers->get('Location'));

    }

}

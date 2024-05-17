<?php

namespace App\Controller;

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


    /**
     * test Game Draw
     *
     * @return void
     */
    public function testGameDraw()
    {

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


    /**
     * test game init
     *
     * @return void
     */
    public function testGameInit()
    {

        $client = static::createClient();

        // Send request
        $client->request('GET', '/game/init');

        // Get response
        $response = $client->getResponse();

        // Check that response is a redirect
        $this->assertTrue($response->isRedirect());

        // Check that route is correct
        $this->assertEquals('/game/round', $response->headers->get('Location'));

    }


    /**
     * test new round route
     *
     * @return void
     */
    public function testGameNewRound()
    {

        $client = static::createClient();

        // Send request
        $client->request('GET', '/game/round');

        // Get response
        $response = $client->getResponse();

        // Check that response is a redirect
        $this->assertTrue($response->isRedirect());

        // Check that route is correct
        $this->assertEquals('/game/play', $response->headers->get('Location'));
    }


    /**
     * test game play route
     *
     * @return void
     */
    public function testGamePlay(): void
    {
        $client = static::createClient();

        $client->request('GET', '/game/play');

        $this->assertResponseIsSuccessful();

        // Check some content in the twig template
        $this->assertSelectorTextContains('h3', 'På tur att spela');
    }


    /**
     * test switch player
     *
     * @return void
     */
    public function testSwitchPlayer()
    {

        $client = static::createClient();

        // Send request
        $client->request('GET', '/game/switch');

        // Get response
        $response = $client->getResponse();

        // Check that response is a redirect
        $this->assertTrue($response->isRedirect());

        // Check that route is correct
        $this->assertEquals('/game/play', $response->headers->get('Location'));
    }


    /**
     * test game bet
     *
     * @return void
     */
    public function testGameBet()
    {

        $client = static::createClient();

        // Send request
        $client->request('POST', '/game/bet');

        // Get response
        $response = $client->getResponse();

        // Check that response is a redirect
        $this->assertTrue($response->isRedirect());

        // Check that route is correct
        $this->assertEquals('/game/play', $response->headers->get('Location'));
    }

}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test cases for class GameController
 */
class CardControllerTest extends WebTestCase
{
    /**
     * Test card start response
     *
     * @return void
     */
    public function testCardStart(): void
    {
        $client = static::createClient();

        $client->request('GET', '/card');

        $this->assertResponseIsSuccessful();

        // Check some content in the twig template
        $this->assertSelectorTextContains('h3', 'Beskrivning av klasserna');
    }



    /**
     * test card/deck route
     *
     * @return void
     */
    public function testCardDeck(): void
    {
        $client = static::createClient();

        $client->request('GET', '/card/deck');

        $this->assertResponseIsSuccessful();

        // Check some content in the twig template
        $this->assertSelectorTextContains('h2', 'Sorterad kortlek');
    }


    /**
     * Test card/deck/sort route
     *
     * @return void
     */
    public function testDeckSort(): void
    {
        $client = static::createClient();

        $client->request('POST', '/card/deck/sort');

        $response = $client->getResponse();

        // Check that response is a redirect
        $this->assertTrue($response->isRedirect());

        // Check that route is correct
        $this->assertEquals('/card/deck', $response->headers->get('Location'));

    }


    /**
     * Test card/deck/init route
     *
     * @return void
     */
    public function testDeckInit(): void
    {
        $client = static::createClient();

        $client->request('POST', '/card/deck/init');

        $response = $client->getResponse();

        // Check that response is a redirect
        $this->assertTrue($response->isRedirect());

        // Check that route is correct
        $this->assertEquals('/card/deck', $response->headers->get('Location'));
    }



    /**
     * Test card/deck/shuffle route
     *
     * @return void
     */
    public function testCardShuffle(): void
    {
        $client = static::createClient();

        $client->request('GET', '/card/deck/shuffle');

        $this->assertResponseIsSuccessful();

        // Check some content in the twig template
        $this->assertSelectorTextContains('h2', 'Blandad kortlek');
    }


    /**
     * test draw card route
     *
     * @return void
     */
    public function testDrawCard(): void
    {
        $client = static::createClient();

        $client->request('GET', '/card/deck/draw');

        $this->assertResponseIsSuccessful();

        // Check some content in the twig template
        $this->assertSelectorTextContains('h2', 'Dragna kort');
    }


    /**
     * test draw num cards route
     *
     * @return void
     */
    public function testDrawCardNum(): void
    {
        $client = static::createClient();

        $client->request('GET', '/card/deck/draw/3');

        $this->assertResponseIsSuccessful();

        // Check some content in the twig template
        $this->assertSelectorTextContains('h2', 'Dragna kort');
    }


    /**
     * test create card hand
     *
     * @return void
     */
    public function testCardHand(): void
    {
        $client = static::createClient();

        $client->request('GET', '/card/deck/deal/2/5');

        $this->assertResponseIsSuccessful();

        // Check some content in the twig template
        $this->assertSelectorTextContains('h2', '2 Spelare med 5 kort i handen');
    }


    /**
     * test create card hand
     *
     * @return void
     */
    public function testcreateCardHand(): void
    {
        $client = static::createClient();

        $client->request('POST', '/card/hand/init');

        $response = $client->getResponse();

        // Check that response is a redirect
        $this->assertTrue($response->isRedirect());

        // Check that rout is correct
        $this->assertEquals('/card/deck/deal/0/0', $response->headers->get('Location'));

    }


}

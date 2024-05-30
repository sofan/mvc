<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test cases for class Poker Squares GameController
 */
class SquareGameControllerTest extends WebTestCase
{
    /**
     * test project route
     *
     * @return void
     */
    public function testGameStart(): void
    {
        $client = static::createClient();

        $client->request('GET', '/proj');

        $this->assertResponseIsSuccessful();

        // Check some content in the twig template
        $this->assertSelectorTextContains('h1', 'Poker Squares');

    }


    /**
     * test about route
     *
     * @return void
     */
    public function testAbout(): void
    {
        $client = static::createClient();

        $client->request('GET', '/proj/about');

        $this->assertResponseIsSuccessful();

        // Check some content in the twig template
        $this->assertSelectorTextContains('h1', 'Om projektet');
    }


    /**
     * test start game
     *
     * @return void
     */
    public function testStartGame(): void
    {
        $client = static::createClient();

        $client->request('POST', '/proj/start');

        $this->assertResponseIsSuccessful();
    }


    /**
     * test draw card
     *
     * @return void
     */
    public function testDrawCard(): void
    {
        $client = static::createClient();

        $client->request('POST', '/proj/draw');

        $this->assertResponseIsSuccessful();
    }



    /**
     * test place card
     *
     * @return void
     */
    public function testPlaceCard(): void
    {
        $client = static::createClient();

        $client->request('POST', '/proj/placecard');

        $this->assertResponseIsSuccessful();
    }
}

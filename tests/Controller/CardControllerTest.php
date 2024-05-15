<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use PHPUnit\Framework\TestCase;
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



    public function testCardDeck(): void
    {
        $client = static::createClient();

        $client->request('GET', '/card/deck');

        $this->assertResponseIsSuccessful();

        // Check some content in the twig template
        $this->assertSelectorTextContains('h2', 'Sorterad kortlek');
    }


}

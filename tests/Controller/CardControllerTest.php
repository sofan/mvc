<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Test cases for class GameController
 */
class CardControllerTest extends WebTestCase
{
    /**
     * Test create deckOfCards
     *
     * @return void
     */
    public function testCreateDeckOfCards(): void
    {
        // Mocka DeckOfCards och CardGraphic om det behövs
        $suits = ['Hearts', 'Clubs', 'Spades', 'Diamonds'];
        $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];

        // Skapa en instans av CardController
        $controller = new CardController();

        // Anropa metoden createDeckOfCards
        $deck = $controller->createDeckOfCards();

        // Kontrollera att resultatet är en instans av DeckOfCards
        $this->assertInstanceOf(DeckOfCards::class, $deck);

        // Kontrollera att kortleken innehåller rätt antal kort
        $expNumCards = count($suits) * count($values);
        $this->assertCount($expNumCards, $deck->getCards());

        // Kontrollera att alla kort är unika
        $uniqueCards = array_unique(array_map(function ($card) {
            return $card->getSuit() . $card->getValue();
        }, $deck->getCards()));

        $this->assertCount($expNumCards, $uniqueCards);

        // Kontrollera att kortleken innehåller kort med rätt färger och värden
        foreach ($deck->getCards() as $card) {
            $this->assertContains($card->getSuit(), $suits);
            $this->assertContains($card->getValue(), $values);
        }
    }



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
        // Mock SessionInterface
        $sessionStub = $this->createMock(SessionInterface::class);

        // Mock DeckOfCards
        $deckOfCards = $this->createMock(DeckOfCards::class);

        // Set expected mock
        $sessionStub->method('get')
                ->with('deck', $this->isInstanceOf(DeckOfCards::class))
                ->willReturn($deckOfCards);

        $deckOfCards->expects($this->once())
                    ->method('sort');

        $sessionStub->expects($this->once())
                ->method('set')
                ->with('deck', $deckOfCards);

        // Create CardController och mock createDeckOfCards function
        $controller = $this->getMockBuilder(CardController::class)
                           ->onlyMethods(['createDeckOfCards', 'redirectToRoute'])
                           ->getMock();
        $controller->method('createDeckOfCards')->willReturn($deckOfCards);

        // Mock redirectToRoute to return a RedirectResponse
        $controller->method('redirectToRoute')
                   ->with('card_deck')
                   ->willReturn(new RedirectResponse('/card/deck'));

        // Run deckSort function
        $response = $controller->deckSort($sessionStub);

        // Check that answer is a RedirectResponse
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('/card/deck', $response->getTargetUrl());
    }


    /**
     * Test card/deck/init route
     *
     * @return void
     */
    public function testDeckInit(): void
    {
        // Mock SessionInterface
        $sessionStub = $this->createMock(SessionInterface::class);

        // Mock DeckOfCards
        $deckOfCards = $this->createMock(DeckOfCards::class);

        $sessionStub->expects($this->once())
        ->method('set')
        ->with('deck', $deckOfCards);

        // Create CardController och mock createDeckOfCards function
        $controller = $this->getMockBuilder(CardController::class)
                           ->onlyMethods(['createDeckOfCards', 'redirectToRoute'])
                           ->getMock();
        $controller->method('createDeckOfCards')->willReturn($deckOfCards);

        // Mock redirectToRoute to return a RedirectResponse
        $controller->method('redirectToRoute')
                   ->with('card_deck')
                   ->willReturn(new RedirectResponse('/card/deck'));

        // Run deckSort function
        $response = $controller->cardDeckInit($sessionStub);

        // Check that answer is a RedirectResponse
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('/card/deck', $response->getTargetUrl());
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

        $crawler = $client->followRedirect();

        //$this->assertCount(4, $crawler->filter('.comment'));

        // Check some content in the twig template
        $this->assertSelectorTextContains('h2', '0 Spelare med 0 kort i handen');
    }


}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test cases for class GameController
 */
class BookControllerTest extends WebTestCase
{
    /**
     * test view all books route
     *
     * @return void
     */
    public function ViewAllBook_test(): void
    {
        $client = static::createClient();

        $client->request('GET', '/library');

        $this->assertResponseIsSuccessful();

        // Check some content in the twig template
        $this->assertSelectorTextContains('h1', 'Böcker');
    }


    /**
     * test create books route
     *
     * @return void
     */
    public function CreateBookGet_test(): void
    {
        $client = static::createClient();

        $client->request('GET', '/book/create');

        $this->assertResponseIsSuccessful();

        // Check some content in the twig template
        $this->assertSelectorTextContains('h1', 'Lägg till ny bok');
    }



}

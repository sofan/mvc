<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MyControllerJson
{
    private $quotes = [
        'Gör det roliga först. Det tråkigare blir mindre tråkigt, när ingenting roligt väntar.',
        'Ungdomen skulle vara ett idealiskt tillstånd om den kom lite senare i livet.',
        'Inget är omöjligt. Det omöjliga tar bara lite längre tid.',
        'Fyll inte livet med dagar, fyll dagarna med liv.',
        'Det sämsta med livserfarenhet är att man har den när man inte behöver den.',
        'Syftet med våra liv är att vara lyckliga.',
        'Skjut upp till imorgon bara det du kan tänka ha ogjort när du dör.',
        'My mama always said, ´Life is like a box of chocolates; you never know what you\'re gonna get"'

    ];

    #[Route("/api/quote", name: "quote")]
    public function apiQuote(): JsonResponse
    {
        $randomQuote = $this->quotes[array_rand($this->quotes)];
        $today =  date("Y-m-d");
        $timestamp = date('H:i:s');

        $data = [
            'quote' => $randomQuote,
            'today' => $today,
            'timestamp' => $timestamp
        ];


        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );


        return $response;



    }

}

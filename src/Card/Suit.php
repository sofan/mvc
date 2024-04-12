<?php

namespace App\Card;

/**
 * Class for card suits
 */
class Suit
{
    public const HEARTS = 'Hearts';
    public const CLUBS = 'Clubs';
    public const SPADES = 'Spades';
    public const DIAMONDS = 'Diamonds';

    public const VALUES13 = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];

    public static function getGraphic($suit)
    {
        switch($suit) {
            case self::HEARTS:
                return '♥️';
            case self::CLUBS:
                return '♣️';
            case self::SPADES:
                return '♠️';
            case self::DIAMONDS:
                return '♦️';
            default:
                return '-';
        }
    }

    public static function getValues13()
    {
        return self::VALUES13;
    }
}

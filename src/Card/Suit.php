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

    public static function getGraphic($suit) {
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
}

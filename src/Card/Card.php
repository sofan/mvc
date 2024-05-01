<?php

namespace App\Card;

/**
 * Card class - Represents a playing card
 */
class Card
{
    /**
     * Suit value
     *
     * @var string The suit of the card (e.g., Hearts, Diamonds, etc.).
     */
    private $suit;

    /**
     * Card value
     *
     * @var string The value of the card
     */
    private $value;

    /**
     * Card constructor
     *
     * @param string $suit The suit of the card.
     * @param string $value The value of the card.
     */
    public function __construct(string $suit, string $value)
    {
        $this->suit = $suit;
        $this->value = $value;
    }


    /**
     * Get card suit
     *
     * @return string The suit
     */
    public function getSuit(): string
    {
        return $this->suit;
    }

    /**
     * Get card value
     *
     * @return string The value
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Get card score
     *
     * @return int The score
     */
    public function getScore(): int
    {
        switch ($this->value) {
            case 'K':
                return 13;
            case 'Q':
                return 12;
            case 'J':
                return 11;
            case 'A':
                return 1;
            default:
                return (int)$this->value;
        }
    }


    /**
     * Get card suit and value as string
     *
     * @return string Card as string
     */
    public function getAsString(): string
    {
        return "[{$this->suit} {$this->value}]";
    }
}

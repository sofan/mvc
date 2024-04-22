<?php

namespace App\Card;

class Card
{
    /**
     * Suit value
     *
     * @var string
     */
    private $suit;

    /**
     * Card value
     *
     * @var string
     */
    private $value;

    /**
     * Card constructor
     *
     * @param string $suit
     * @param string $value
     */
    public function __construct(string $suit, string $value)
    {
        $this->suit = $suit;
        $this->value = $value;
    }


    /**
     * Get card suit
     *
     * @return string
     */
    public function getSuit(): string
    {
        return $this->suit;
    }

    /**
     * Get card value
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Get card scort
     *
     * @return int
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
     * @return string
     */
    public function getAsString(): string
    {
        return "[{$this->suit} {$this->value}]";
    }
}

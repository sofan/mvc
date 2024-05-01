<?php

namespace App\Dice;

class DiceGraphic extends Dice
{
    /**
     *
     * @var string[]
     */
    private $representation = [
        '⚀',
        '⚁',
        '⚂',
        '⚃',
        '⚄',
        '⚅',
    ];



    public function getAsString(): string
    {
        return $this->representation[$this->value - 1];
    }
}

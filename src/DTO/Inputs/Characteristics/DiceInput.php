<?php

declare(strict_types=1);

namespace App\DTO\Inputs\Characteristics;


class DiceInput extends InputAbstract
{
    private array $dices;
    private string $diceHash;

    /**
     * Get the value of dices
     */
    public function getDices()
    {
        return $this->dices;
    }

    /**
     * Set the value of dices
     *
     * @return  self
     */
    public function setDices($dices)
    {
        $this->dices = $dices;

        return $this;
    }

    /**
     * Get the value of diceHash
     */
    public function getDiceHash()
    {
        return $this->diceHash;
    }

    /**
     * Set the value of diceHash
     *
     * @return  self
     */
    public function setDiceHash($diceHash)
    {
        $this->diceHash = $diceHash;

        return $this;
    }
}

<?php

namespace App\Controller;

use App\Domain\Data\CharacteristicsEnum;
use App\Domain\Personnages\Characteristiques\CharacRules;

class Characteristics
{

    public int $intelligence;
    public int $force;
    public int $dexterite;
    public int $charisme;
    public int $endurance;
    private CharacRules $rules;
    private ?array $dices;

    /**
     * Get the value of rules
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Set the value of rules
     *
     * @return  self
     */
    public function setRules($rules)
    {
        $this->rules = $rules;

        return $this;
    }

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
}

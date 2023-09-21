<?php

namespace App\DTO\Inputs\Characteristics;

abstract class InputAbstract
{

    public int $intelligence;
    public int $force;
    public int $dexterite;
    public int $charisme;
    public int $endurance;
    protected string $personnage;
    public function toArray(): array
    {
        return array(
            'intelligence' => $this->intelligence,
            'force' => $this->force,
            'dexterite' => $this->dexterite,
            'charisme' => $this->charisme,
            'endurance' => $this->endurance,
        );
    }

    /**
     * Get the value of personnage
     */
    public function getPersonnage()
    {
        return $this->personnage;
    }

    /**
     * Set the value of personnage
     *
     * @return  self
     */
    public function setPersonnage($personnage)
    {
        $this->personnage = $personnage;

        return $this;
    }
}

<?php

namespace App\DTO;

use App\Domain\Data\CharacteristicsEnum;
use App\Domain\Model\Personnage;
use App\Domain\Personnages\Characteristiques\CharacRules;
use Symfony\Component\DomCrawler\UriResolver;

class CharacteristicsInput
{

    public int $intelligence;
    public int $force;
    public int $dexterite;
    public int $charisme;
    public int $endurance;
    private string $personnage;
    /**
     * @param $dices array<int>
     */
    private ?array $dices;
    private CharacRules $rules;



    /**
     * Get the value of rules
     */
    public function getRules(): CharacRules
    {
        return $this->rules;
    }

    /**
     * Set the value of rules
     *
     * @return  self
     */
    public function setRules(string $rules): self
    {
        $this->rules = CharacRules::from($rules);

        return $this;
    }

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

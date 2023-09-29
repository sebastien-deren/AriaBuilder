<?php

declare(strict_types=1);

namespace App\Domain\Logic\Characteristiques\Processors;

use App\Domain\Model\Caracteristique;
use App\DTO\Inputs\Characteristics\InputAbstract;

trait DicesTrait
{
    private function createTwenty(InputAbstract $inputCharac): Caracteristique
    {
        return (new Caracteristique())
            ->setCharisme(($inputCharac->charisme * 5))
            ->setDexterite(($inputCharac->dexterite * 5))
            ->setForce(($inputCharac->force * 5))
            ->setEndurance(($inputCharac->endurance * 5))
            ->setIntelligence(($inputCharac->intelligence * 5));
    }
    private function CheckDices(array $dices, string $hash): bool
    {
        return true;
    }
}

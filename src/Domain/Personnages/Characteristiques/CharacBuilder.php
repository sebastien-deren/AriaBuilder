<?php

declare(strict_types=1);

namespace App\Domain\Personnages\Characteristiques;

use Exception;

use App\Controller\Characteristics;
use App\Domain\Model\Caracteristique;
use App\Domain\Personnages\Characteristiques\CharacBuilderInterface;

class CharacBuilder implements CharacBuilderInterface
{
    public function Build(Characteristics $baseCharac): Caracteristique
    {
        $builtCharac = new Caracteristique();
        foreach ($baseCharac as $characName => $characValue) {
            if ($characValue > 80 || $characValue < 10) {
                throw new Exception("Error Processing Request",);
            }
        }
        $builtCharac
            ->setCharisme($baseCharac->charisme)
            ->setDexterite($baseCharac->dexterite)
            ->setForce($baseCharac->force)
            ->setEndurance($baseCharac->endurance)
            ->setIntelligence($baseCharac->intelligence);
        return $builtCharac;
    }
}

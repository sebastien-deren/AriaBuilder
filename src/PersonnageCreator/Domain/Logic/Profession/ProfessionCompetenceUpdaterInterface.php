<?php

declare(strict_types=1);

namespace App\PersonnageCreator\Domain\Logic\Profession;

use App\Domain\Model\Personnage;

interface ProfessionCompetenceUpdaterInterface
{
    public function updateCompetenceFromProfession(array $previousPersonnage, Personnage $currentPersonnage): void;
}

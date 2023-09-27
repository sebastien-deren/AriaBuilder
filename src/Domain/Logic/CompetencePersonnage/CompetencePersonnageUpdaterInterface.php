<?php

declare(strict_types=1);

namespace App\Domain\Logic\CompetencePersonnage;

use App\Domain\Model\Competence;
use App\Domain\Model\Personnage;

interface CompetencePersonnageUpdaterInterface
{
    public function updateCompetencePercentage(Competence $competence, Personnage $personnage, UpgradeCompetenceEnum $backedEnum): void;
}

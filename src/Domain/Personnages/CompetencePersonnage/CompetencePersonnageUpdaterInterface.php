<?php

declare(strict_types=1);

namespace App\Domain\Personnages\CompetencePersonnage;

use App\Domain\Background\BackgroundEnum;
use App\Domain\Model\Competence;
use App\Domain\Model\Personnage;
use App\Domain\Personnages\Profession\UpgradProfessionEnum;
use BackedEnum;

interface CompetencePersonnageUpdaterInterface
{
    public function updateCompetencePercentage(Competence $competence, Personnage $personnage, UpgradeCompetenceEnum $backedEnum): void;
}

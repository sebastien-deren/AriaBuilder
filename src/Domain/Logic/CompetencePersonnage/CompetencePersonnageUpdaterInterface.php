<?php

declare(strict_types=1);

namespace App\Domain\Logic\CompetencePersonnage;

use App\Domain\Model\CompetencePersonnage;
use Doctrine\Common\Collections\Collection;

interface CompetencePersonnageUpdaterInterface
{
    public function updateCompetence(CompetencePersonnage $competencePersonnage, UpgradeCompetenceEnum $enum): CompetencePersonnage;
    public function updateCompetenceCollection(Collection $competences, UpgradeCompetenceEnum $enum): Collection;
}

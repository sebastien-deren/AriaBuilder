<?php

declare(strict_types=1);

namespace App\Domain\Logic\Talent;

use App\Domain\Logic\CompetencePersonnage\CompetencePersonnageUpdaterNewI;
use App\Domain\Model\Talent;

class TalentCompetenceUpdater implements TalentCompetenceUpdaterInterface
{
    public function __construct(private CompetencePersonnageUpdaterNewI $competenceUpdater)
    {
    }
    public function updateCompetenceFromTalent(Talent $talent): Talent
    {
        foreach ($talent->getUpgradedCompetence() as $competence) {
            $competence->setPourcentage($competence->getPourcentage() + $talent->getBonus()->value);
        }

        return $talent;
    }
}

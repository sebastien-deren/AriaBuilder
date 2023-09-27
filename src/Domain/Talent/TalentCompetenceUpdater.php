<?php

declare(strict_types=1);

namespace App\Domain\Talent;

use App\Domain\Model\Talent;

class TalentCompetenceUpdater implements TalentCompetenceUpdaterInterface
{
    public function updateCompetenceFromTalent(Talent $talent): Talent
    {
        foreach ($talent->getUpgradedCompetence() as $competence) {
            $competence->setPourcentage($competence->getPourcentage() + $talent->getBonus()->value);
        }

        return $talent;
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Logic\Talent;

use App\Domain\Logic\CompetencePersonnage\CompetencePersonnageUpdaterInterface;
use App\Domain\Model\Talent;

class TalentCompetenceUpdater implements TalentCompetenceUpdaterInterface
{
    public function __construct(private CompetencePersonnageUpdaterInterface $competenceUpdater)
    {
    }
    public function updateCompetenceFromTalent(Talent $talent): Talent
    {
        $this->competenceUpdater->updateCompetenceCollection($talent->getUpgradedCompetence(), $talent->getBonus());
        return $talent;
    }
}

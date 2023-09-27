<?php

declare(strict_types=1);

namespace App\Domain\Talent;

use App\Domain\Personnages\CompetencePersonnage\UpgradeCompetenceEnum;

class TalentParam
{
    public function __construct(public int $talentNumber, public UpgradeCompetenceEnum $bonus = UpgradeCompetenceEnum::Default)
    {
    }
}

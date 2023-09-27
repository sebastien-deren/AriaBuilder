<?php

declare(strict_types=1);

namespace App\Domain\Logic\Talent;

use App\Domain\Logic\CompetencePersonnage\UpgradeCompetenceEnum;

class TalentParam
{
    public function __construct(public int $talentNumber, public UpgradeCompetenceEnum $bonus = UpgradeCompetenceEnum::Default)
    {
    }
}

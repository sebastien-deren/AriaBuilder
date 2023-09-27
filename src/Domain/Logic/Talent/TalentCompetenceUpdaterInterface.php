<?php

declare(strict_types=1);

namespace App\Domain\Logic\Talent;

use App\Domain\Model\Talent;

interface TalentCompetenceUpdaterInterface
{
    public function updateCompetenceFromTalent(Talent $talent): Talent;
}

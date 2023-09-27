<?php

declare(strict_types=1);

namespace App\Domain\Talent;

use App\Domain\Model\Talent;

interface TalentCompetenceUpdaterInterface
{
    public function updateCompetenceFromTalent(Talent $talent): Talent;
}

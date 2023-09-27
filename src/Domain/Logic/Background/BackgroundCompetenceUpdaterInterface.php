<?php

declare(strict_types=1);

namespace App\Domain\Logic\Background;

use App\Domain\Model\Background;

interface BackgroundCompetenceUpdaterInterface
{

    public function updateCompetenceFromBackground(Background $background): Background;
}

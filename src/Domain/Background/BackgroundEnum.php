<?php

declare(strict_types=1);

namespace App\Domain\Background;

use App\Domain\Personnages\CompetencePersonnage\CompetenceUpdateEnumInterface;

enum BackgroundEnum: int
{
    case Bonus = 10;
    case Malus = -10;
}

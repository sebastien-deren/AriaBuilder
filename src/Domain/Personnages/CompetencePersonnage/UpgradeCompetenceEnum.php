<?php

declare(strict_types=1);

namespace App\Domain\Personnages\CompetencePersonnage;

enum UpgradeCompetenceEnum: int
{
    case Bonus = 10;
    case Malus = -10;
    case LitteBonus = 5;
    case Default = 0;
}

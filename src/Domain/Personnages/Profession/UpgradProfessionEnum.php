<?php

declare(strict_types=1);

namespace App\Domain\Personnages\Profession;

enum UpgradProfessionEnum: int
{

    case Upgrade = 10;
    case Downgrade = -10;
}

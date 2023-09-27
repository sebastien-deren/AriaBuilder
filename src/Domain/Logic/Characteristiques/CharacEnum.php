<?php

declare(strict_types=1);

namespace App\Domain\Logic\Characteristiques;

enum CharacEnum: string
{
    case Force = "force";
    case Dexterite = "dexterite";
    case Endurance = "endurance";
    case Intelligence = "intelligence";
    case Charisme = "charisme";
}

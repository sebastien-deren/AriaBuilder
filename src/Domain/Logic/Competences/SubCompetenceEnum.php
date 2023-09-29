<?php

declare(strict_types=1);

namespace App\Domain\Logic\Competences;

enum SubCompetenceEnum: string
{
    case Force = 'force';
    case Intelligence = 'intelligence';
    case Dexterite = 'dexterite';
    case Charisme = 'charisme';
    case Endurance = 'endurance';
}

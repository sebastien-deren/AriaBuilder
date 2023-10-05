<?php

declare(strict_types=1);

namespace App\Domain\Logic\Competences;

enum SubCompetenceEnum: string
{
    case Force = 'Force';
    case Intelligence = 'Intelligence';
    case Dexterite = 'Dexterite';
    case Charisme = 'Charisme';
    case Endurance = 'Endurance';
}

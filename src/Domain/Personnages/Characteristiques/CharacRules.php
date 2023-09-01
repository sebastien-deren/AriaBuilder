<?php

declare(strict_types=1);

namespace App\Domain\Personnages\Characteristiques;

enum CharacRules: string
{
    case Point = "point";
    case Dice = 'dice';
    case ThreeDices = 'three dices';
}

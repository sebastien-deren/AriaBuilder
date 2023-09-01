<?php

namespace App\Domain\Personnages\Characteristiques;

enum CharacLimitEnum: int
{
    case Max100 = 80;
    case Min100 = 10;
    case Max20 = 18;
    case Min20 = 3;
}

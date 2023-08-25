<?php

namespace App\Domain\Personnages\Characteristiques;

use App\Domain\Model\Caracteristique;

interface CharacBuilderInterface
{
    public function Build(Characteristics $baseCharac): Caracteristique;
}

<?php

namespace App\Domain\Personnages\Characteristiques;

use App\DTO\CharacteristicsInput as Characteristics;
use App\Domain\Model\Caracteristique;

interface CharacBuilderInterface
{
    public function build(Characteristics $baseCharac): Caracteristique;
}

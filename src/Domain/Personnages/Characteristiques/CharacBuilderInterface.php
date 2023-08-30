<?php

namespace App\Domain\Personnages\Characteristiques;

use App\Controller\Characteristics;
use App\Domain\Model\Caracteristique;

interface CharacBuilderInterface
{
    public function build(Characteristics $baseCharac): Caracteristique;
}

<?php

namespace App\Domain\Personnages\Characteristiques\Processors;

use App\Domain\Model\Caracteristique;
use App\DTO\Inputs\Characteristics\InputAbstract;

interface CharacBuilderInterface
{
    public function build(InputAbstract $baseCharac): Caracteristique;
}

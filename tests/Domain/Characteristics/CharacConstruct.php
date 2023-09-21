<?php

declare(strict_types=1);

namespace App\Tests\Domain\Characteristics;

use App\DTO\Inputs\Characteristics\InputAbstract;
use App\DTO\Inputs\Characteristics\PointInput;

trait CharacConstruct
{
    private function characConstruct(array $value, InputAbstract $baseCharac): InputAbstract
    {

        $baseCharac->charisme = $value[0];
        $baseCharac->dexterite = $value[1];
        $baseCharac->endurance = $value[2];
        $baseCharac->force = $value[3];
        $baseCharac->intelligence = $value[4];
        $baseCharac->setPersonnage('null');
        return $baseCharac;
    }
}

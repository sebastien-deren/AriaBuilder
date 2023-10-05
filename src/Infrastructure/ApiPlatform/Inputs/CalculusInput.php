<?php

declare(strict_types=1);

namespace App\Infrastructure\ApiPlatform\Inputs;

use App\Domain\Logic\Competences\DTO\CompetenceAbstract;

class CalculusInput extends CompetenceAbstract
{
    public bool $isCalculated;
}

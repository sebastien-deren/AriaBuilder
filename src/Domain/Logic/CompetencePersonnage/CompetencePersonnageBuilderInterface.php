<?php

declare(strict_types=1);

namespace App\Domain\Logic\CompetencePersonnage;

use App\Domain\Logic\CompetencePersonnage\DTO\CompetencePersonnage as CompetencePersonnageExterior;
use App\Domain\Model\CompetencePersonnage;

interface CompetencePersonnageBuilderInterface
{
    public function create(CompetencePersonnageExterior $input): CompetencePersonnage;
}

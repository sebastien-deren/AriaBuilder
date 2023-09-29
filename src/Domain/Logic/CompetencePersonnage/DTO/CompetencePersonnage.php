<?php

declare(strict_types=1);

namespace App\Domain\Logic\CompetencePersonnage\DTO;

use App\Domain\Model\Competence;
use App\Domain\Model\Personnage;

class CompetencePersonnage
{
    public function __construct(
        public Personnage $personnage,
        public Competence $competence,
    ) {
    }
}

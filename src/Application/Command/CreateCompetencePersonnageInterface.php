<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\Competence;
use App\Domain\Model\CompetencePersonnage;
use App\Domain\Model\Personnage;

interface CreateCompetencePersonnageInterface
{
    public function handle(Personnage $personnage, Competence $competence): CompetencePersonnage;
}

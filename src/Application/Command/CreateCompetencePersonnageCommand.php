<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Application\Command\CreateCompetencePersonnageInterface;
use App\Domain\Logic\CompetencePersonnage\CompetencePersonnageBuilderInterface;
use App\Domain\Logic\CompetencePersonnage\DTO\CompetencePersonnage as CompetencePersonnageExterior;
use App\Domain\Model\Competence;
use App\Domain\Model\CompetencePersonnage;
use App\Domain\Model\Personnage;

class CreateCompetencePersonnageCommand implements CreateCompetencePersonnageInterface
{
    public function __construct(private CompetencePersonnageBuilderInterface $builder)
    {
    }
    public function handle(Personnage $personnage, Competence $competence): CompetencePersonnage
    {
        $dto = new CompetencePersonnageExterior($personnage, $competence);
        return $this->builder->create($dto);
    }
}

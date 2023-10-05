<?php

declare(strict_types=1);

namespace App\Infrastructure\ApiPlatform\Outputs;

use App\Domain\Model\CompetencePersonnage;

class CompetencePersonnageOutput
{

    public ?int $id;
    public ?string $personage;
    public ?string $competence;
    public ?int $pourcentage;
    public function __construct(CompetencePersonnage $competencePersonnage)
    {
        $this->id = $competencePersonnage->getId();
        $this->personage = $competencePersonnage->getPersonage();
        $this->competence = $competencePersonnage->getCompetence();
        $this->pourcentage = $competencePersonnage->getPourcentage();
    }
}

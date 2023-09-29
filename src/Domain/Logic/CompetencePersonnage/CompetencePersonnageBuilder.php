<?php

declare(strict_types=1);

namespace App\Domain\Logic\CompetencePersonnage;

use App\Domain\Model\Competence;
use App\Domain\Model\CompetencePersonnage;
use App\Domain\Model\Personnage;
use App\Domain\Logic\CompetencePersonnage\DTO\CompetencePersonnage as CompetencePersonnageExterior;

class CompetencePersonnageBuilder implements CompetencePersonnageBuilderInterface
{

    public function create(CompetencePersonnageExterior $input): CompetencePersonnage
    {
        $competence = $input->competence;
        $personnage = $input->personnage;

        if (!($competence instanceof Competence) || !($personnage instanceof Personnage)) {
            throw new \Exception();
        }
        if (null === $caracPerso = $personnage->getCaracteristique()) {
            throw new \Exception('We need carac to create Competences');
        }
        $functionFirstCharac = 'get' . $competence->getFirstCharac()->name;
        $functionSecondCharac = 'get' . $competence->getSecondCharac()->name;
        $percent = (int)(($caracPerso->$functionSecondCharac() + $caracPerso->$functionFirstCharac()) / 2);
        return (new CompetencePersonnage())
            ->setCompetence($competence)
            ->setPersonage($personnage)
            ->setPourcentage($percent);
    }
}

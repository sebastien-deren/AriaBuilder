<?php

declare(strict_types=1);

namespace App\Domain\Logic\CompetencePersonnage;

use App\Domain\Model\Competence;
use App\Domain\Model\CompetencePersonnage;
use App\Domain\Model\Personnage;
use App\Domain\Logic\Profession\UpgradProfessionEnum;
use BackedEnum;
use Exception;

class CompetencePersonnageUpdater implements CompetencePersonnageUpdaterInterface
{
    public function updateCompetencePercentage(Competence $competence, Personnage $personnage, UpgradeCompetenceEnum $backedEnum): void
    {
        $compPersonnage = $personnage->getCompetence();
        //here we need to be sure that CompetencePersonnage->getCompetence() is unique for each user
        $updateCompetence = $compPersonnage->findFirst(
            fn (int $index, CompetencePersonnage $competenceperso) => $competence === $competenceperso->getCompetence()
        );
        if (null === $updateCompetence) {
            throw new Exception('CompetencePersonnage Doesn\'t exist');
        }
        $updateCompetence->setPourcentage($updateCompetence->getPourcentage() + $backedEnum->value);
    }
}

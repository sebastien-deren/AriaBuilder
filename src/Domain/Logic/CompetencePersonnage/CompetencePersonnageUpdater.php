<?php

declare(strict_types=1);

namespace App\Domain\Logic\CompetencePersonnage;

use App\Domain\Model\CompetencePersonnage;
use Doctrine\Common\Collections\Collection;

class CompetencePersonnageUpdater implements CompetencePersonnageUpdaterInterface
{

    public function updateCompetence(CompetencePersonnage $competencePersonnage, UpgradeCompetenceEnum $enum): CompetencePersonnage
    {
        $competencePersonnage->setPourcentage($competencePersonnage->getPourcentage() + $enum->value);
        return $competencePersonnage;
    }
    public function updateCompetenceCollection(Collection $competences, UpgradeCompetenceEnum $enum): Collection
    {
        foreach ($competences as $competence) {
            $this->updateCompetence($competence, $enum);
        }
        return $competences;
    }
}

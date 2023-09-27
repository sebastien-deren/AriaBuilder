<?php

declare(strict_types=1);

namespace App\Domain\Logic\Profession;

use App\Domain\Logic\CompetencePersonnage\CompetencePersonnageUpdater;
use App\Domain\Logic\CompetencePersonnage\CompetencePersonnageUpdaterInterface;
use App\Domain\Logic\CompetencePersonnage\UpgradeCompetenceEnum;
use App\Domain\Model\Personnage;
use App\Domain\Model\Profession;
//NOT HEXAGONAL
use Doctrine\Common\Collections\Collection;
use App\Domain\Logic\Profession\UpgradProfessionEnum;

final class ProfessionCompetenceUpdater implements ProfessionCompetenceUpdaterInterface
{
    public function __construct(private CompetencePersonnageUpdaterInterface $competencePersonnageUpdater)
    {
    }
    public function updateCompetenceFromProfession(array $previousPersonnage, Personnage $currentPersonnage): void
    {
        if (empty($previousPersonnage['profession'])) {
            $this->updateCompetences($currentPersonnage->getProfession(), $currentPersonnage->getCompetence(), UpgradeCompetenceEnum::Bonus);
            return;
        }
        if ($previousPersonnage['profession'] === $currentPersonnage->getProfession()) {
            return;
        }
        $this->updateCompetences(
            $previousPersonnage['profession'],
            $currentPersonnage->getCompetence(),
            UpgradeCompetenceEnum::Malus,
        );
        $this->updateCompetences(
            $previousPersonnage['profession'],
            $currentPersonnage->getCompetence(),
            UpgradeCompetenceEnum::Bonus,
        );
        return;
    }
    private function updateCompetences(
        ?Profession $profession,
        Collection $competencesPersonnage,
        UpgradeCompetenceEnum $enum
    ): void {
        if (null === $profession) {
            return;
        }
        $competencesProfession = $profession->getCompetenceProfessions();


        $competenceToUpdate = $competencesPersonnage
            ->filter(
                fn ($competence) =>
                $competencesProfession->contains($competence->getCompetence())
            );
        $this->competencePersonnageUpdater->updateCompetenceCollection($competenceToUpdate, $enum);
        return;
    }
}

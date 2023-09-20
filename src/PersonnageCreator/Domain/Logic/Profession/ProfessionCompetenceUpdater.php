<?php

declare(strict_types=1);

namespace App\PersonnageCreator\Domain\Logic\Profession;

use App\Domain\Model\Personnage;
use App\PersonnageCreator\Domain\Model\Profession;
use App\PersonnageCreator\Domain\Logic\Profession\UpgradProfessionEnum;
use App\Domain\Personnages\CompetencePersonnage\CollectionCompetencePersonnage;
use Doctrine\Common\Collections\Collection;

final class ProfessionCompetenceUpdater implements ProfessionCompetenceUpdaterInterface
{
    public function updateCompetenceFromProfession(array $previousPersonnage, Personnage $currentPersonnage): void
    {
        if (empty($previousPersonnage['profession'])) {
            $this->updateCompetences($currentPersonnage->getProfession(), $currentPersonnage->getCompetence(), UpgradProfessionEnum::Upgrade);
            return;
        }
        if ($previousPersonnage['profession'] === $currentPersonnage->getProfession()) {
            return;
        }
        $this->updateCompetences(
            $previousPersonnage['profession'],
            $currentPersonnage->getCompetence(),
            UpgradProfessionEnum::Downgrade,
        );
        $this->updateCompetences(
            $previousPersonnage['profession'],
            $currentPersonnage->getCompetence(),
            UpgradProfessionEnum::Upgrade,
        );
        return;
    }
    /**
     * @param ?Profession $profession
     * @param UpgradProfessionEnum $enum
     */
    /*I don't understand why $currentPersonnage->getCompetence() give me an error
        It seems to me that i decorate well enough my collection so that ->getCompetence() should give me CollectionCompetencePersonnage
        */
    private function updateCompetences(
        ?Profession $profession,
        Collection $competencesPersonnage,
        UpgradProfessionEnum $enum
    ): void {
        if (null === $profession) {
            return;
        }
        $competencesProfession = $profession->getCompetenceProfessions();


        $competencesPersonnage
            ->filter(
                fn ($competence) =>
                $competencesProfession->contains($competence->getCompetence())
            )
            ->map(
                function ($competence) use ($enum) {
                    $competence->setPourcentage($competence->getPourcentage() + $enum->value);

                    dump($competence);
                }
            );

        return;
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Personnages\Profession;

use App\Domain\Model\Personnage;
use App\Domain\Model\Profession;
use App\Domain\Model\CompetencePersonnage;
use App\Domain\Personnages\CompetencePersonnage\CollectionCompetencePersonnage;
use Doctrine\Common\Collections\Collection;
use App\Domain\Personnages\Profession\UpgradProfessionEnum;
use App\Domain\Personnages\CompetencePersonnage\CollectionCompetencePersonnageInterface;

final class ProfessionCompetenceUpdater
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
        CollectionCompetencePersonnage $competencesPersonnage,
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

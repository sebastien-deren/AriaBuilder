<?php

declare(strict_types=1);

namespace App\EntityListener;

use Doctrine\ORM\Events;
use App\Domain\Model\Personnage;
use App\Domain\Model\Profession;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Model\CompetencePersonnage;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Common\Collections\Collection;
use App\Domain\Personnages\ChangeCompetencePourcentage;
use App\Repository\CompetencePersonnageRepository;
use App\Repository\PersonnageRepository;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\UnitOfWork;
use Doctrine\Persistence\ObjectManager;


class PersonnageProfessionUpdater
{
    public function __construct(private EntityManagerInterface $entityManagerInterface)
    {
    }

    public function preUpdate(Personnage $personnage, PreUpdateEventArgs $preUpdateEventArgs)
    {
        if (!$preUpdateEventArgs->hasChangedField('profession')) {
            return;
        }
        $preUpdateEventArgs->getObjectManager()->getRepository(Personnage::class);
        $competencePersonnage = $personnage->getCompetence();
        $this->updateProfession(
            $preUpdateEventArgs->getOldValue('profession'),
            $competencePersonnage,
            UpgradProfessionEnum::Downgrade,
        );
        $this->updateProfession(
            $preUpdateEventArgs->getNewValue('profession'),
            $competencePersonnage,
            UpgradProfessionEnum::Upgrade,
        );
    }
    private function updateProfession(
        ?Profession $profession,
        Collection $competencesPersonnage,
        UpgradProfessionEnum $enum,
    ) {
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
                }
            );
    }
}

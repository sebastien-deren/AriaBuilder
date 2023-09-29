<?php

declare(strict_types=1);

namespace App\EntityListener;

use App\Domain\Model\CompetencePersonnage;
use App\Domain\Model\Personnage;
use App\Domain\Model\Profession;
use App\Domain\Logic\ChangeCompetencePourcentage;
use App\Domain\Logic\Profession\UpgradProfessionEnum;
use App\Repository\CompetencePersonnageRepository;
use App\Repository\PersonnageRepository;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
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

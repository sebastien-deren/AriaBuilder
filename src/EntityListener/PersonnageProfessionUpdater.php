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

#[AsEntityListener(event: Events::preUpdate, method: 'preupdate', entity: Personnage::class)]
class PersonnageProfessionUpdater
{
    public function __construct(private EntityManagerInterface $entityManagerInterface)
    {
    }

    public function preUpdate(Personnage $personnage, PreUpdateEventArgs $preUpdateEventArgs)
    {
        dump('PERSONNAGE UPDATE');
        if (!$preUpdateEventArgs->hasChangedField('profession')) {
            return;
        }
        $preUpdateEventArgs->getObjectManager()->getRepository(Personnage::class);
        $competencePersonnage = $personnage->getCompetence();
        $this->updateProfession(
            $preUpdateEventArgs->getOldValue('profession'),
            $competencePersonnage,
            UpgradProfessionEnum::Downgrade,
            $preUpdateEventArgs->getObjectManager()
        );
        $this->updateProfession(
            $preUpdateEventArgs->getNewValue('profession'),
            $competencePersonnage,
            UpgradProfessionEnum::Upgrade,
            $preUpdateEventArgs->getObjectManager()
        );
    }
    private function updateProfession(
        ?Profession $profession,
        Collection $competencesPersonnage,
        UpgradProfessionEnum $enum,
        ObjectManager $objectManager
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
                function ($competence) use ($enum, $objectManager) {
                    $competence->setPourcentage($competence->getPourcentage() + $enum->value);
                }
            );
    }
}

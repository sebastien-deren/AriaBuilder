<?php

namespace App\State;

use Exception;
use ApiPlatform\Metadata\Patch;
use Doctrine\ORM\EntityManager;
use App\Domain\Model\Personnage;
use App\Domain\Model\Profession;
use ApiPlatform\Metadata\Operation;
use App\Repository\PersonnageRepository;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\Domain\Model\CompetencePersonnage;
use Doctrine\Common\Collections\Collection;
use App\EntityListener\UpgradProfessionEnum;
use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use App\Domain\Personnages\Profession\ProfessionCompetenceUpdaterInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class PersonnageUpdaterProcessor implements ProcessorInterface
{
    public function __construct(#[Autowire(service: PersistProcessor::class)] private ProcessorInterface $persistProcessor, private EntityManagerInterface $entityManager, private ProfessionCompetenceUpdaterInterface $professionUpdater)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!$operation instanceof Patch) {
            throw new Exception('unreachable Exception');
        }
        $uow = $this->entityManager->getUnitOfWork();
        $previousPersonnage = $uow->getOriginalEntityData($data);
        if (null !== $data->getProfession()) {
            $this->updateProfession($previousPersonnage, $data);
        }

        $result = $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        return $data;
    }

}

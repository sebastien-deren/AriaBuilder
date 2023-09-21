<?php

namespace App\State;

use Exception;
use ApiPlatform\Metadata\Patch;

use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\PersonnageCreator\Domain\Logic\Profession\ProfessionCompetenceUpdaterInterface;

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
            $this->professionUpdater->updateCompetenceFromProfession($previousPersonnage, $data);
        }

        $result = $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        return $result;
    }
}

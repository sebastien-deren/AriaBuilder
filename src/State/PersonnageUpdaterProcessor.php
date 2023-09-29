<?php

namespace App\State;

use Exception;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use App\Domain\Exception\UnreachableException;
use App\Domain\Logic\Profession\ProfessionCompetenceUpdaterInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class PersonnageUpdaterProcessor implements ProcessorInterface
{
    public function __construct(#[Autowire(service: PersistProcessor::class)] private ProcessorInterface $persistProcessor, private EntityManagerInterface $entityManager, private ProfessionCompetenceUpdaterInterface $professionUpdater)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!$operation instanceof Patch) {
            throw new UnreachableException();
        }
        $uow = $this->entityManager->getUnitOfWork();
        $previousPersonnage = $uow->getOriginalEntityData($data);
        if (null !== $data->getProfession()) {
            $this->professionUpdater->updateCompetenceFromProfession($previousPersonnage, $data);
        }

        $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        return $data;
    }
}

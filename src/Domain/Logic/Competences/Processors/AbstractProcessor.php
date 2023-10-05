<?php

declare(strict_types=1);

namespace App\Domain\Logic\Competences\Processors;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Domain\Logic\Competences\DTO\CompetenceAbstract;
use App\Domain\Model\Personnage;
use App\DTO\Input\Competence\CompetenceInputAbstract;
use App\Infrastructure\Doctrine\Repository\CompetenceRepository;
use App\Infrastructure\Doctrine\Repository\PersonnageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

abstract class AbstractProcessor implements ProcessorInterface
{

    public function __construct(
        protected EntityManagerInterface $entityManager,
        private CompetenceRepository $competenceRepository,
        private PersonnageRepository $personnageRepository
    ) {
    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $baseCompetenceCollection = $this->competenceRepository->findBy(['isBaseCompetence' => true]);
        $personnage = $this->personnageRepository->find($uriVariables['id_perso']) ?? throw new Exception('404 entity not found');
        $this->buildCollection($data, $baseCompetenceCollection, $personnage);
    }
    protected function buildCollection(CompetenceAbstract $data, array $baseCompetence, Personnage $personnage): array
    {
        return [];
    }
}

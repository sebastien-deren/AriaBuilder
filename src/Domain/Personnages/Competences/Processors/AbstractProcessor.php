<?php

declare(strict_types=1);

namespace App\Domain\Personnages\Competences\Processors;

use Exception;
use App\Domain\Model\Personnage;
use ApiPlatform\Metadata\Operation;
use App\Repository\CompetenceRepository;
use App\Repository\PersonnageRepository;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\DTO\Input\Competence\CompetenceInputAbstract;

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
    protected function buildCollection(CompetenceInputAbstract $data, array $baseCompetence, Personnage $personnage): array
    {
        return [];
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastucture\Doctrine\Collection;

use App\Domain\Model\Competence;
use App\Domain\Model\CompetencePersonnage;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;

class CollectionCompetencePersonnage extends Collection
{
    public function __construct(protected EntityManager $entityManager)
    {
        parent::__construct($entityManager);
        $this->collection = $this->entityManager->getRepository(CompetencePersonnage::class);
    }
}

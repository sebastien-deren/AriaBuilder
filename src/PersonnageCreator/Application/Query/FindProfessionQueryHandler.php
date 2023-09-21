<?php

declare(strict_types=1);

namespace App\PersonnageCreator\Application\Query;

use App\PersonnageCreator\Domain\Repository\ProfessionRepositoryInterface;
use App\Repository\ProfessionRepository;

class FindProfessionQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ProfessionRepositoryInterface $professionRepository)
    {
    }
    public function ask(FindProfessionQuery $query): mixed
    {
        return $this->professionRepository->getOne($query->id);
    }
}

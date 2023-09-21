<?php

declare(strict_types=1);

namespace App\PersonnageCreator\Application\Query;

use App\PersonnageCreator\Domain\Repository\ProfessionRepositoryInterface;

class FindProfessionsQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ProfessionRepositoryInterface $professionRepository)
    {
    }
    public function ask(FindProfessionsQuery $query)
    {
        return $this->professionRepository->getAll();

        //return $this->professionRepository->getWithPagination($query->page, $query->limit);
    }
}

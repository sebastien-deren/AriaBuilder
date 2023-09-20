<?php

declare(strict_types=1);

namespace App\PersonnageCreator\Application\Query;

use App\PersonnageCreator\Domain\Repository\ProfessionRepositoryInterface;

class FindProfessionsQuery
{
    public function __construct(private ProfessionRepositoryInterface $professionRepository)
    {
    }
    public function ask(mixed $item = null)
    {
        return $this->professionRepository->getAll();
    }
}

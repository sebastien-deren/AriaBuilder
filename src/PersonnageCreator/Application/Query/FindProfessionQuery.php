<?php

declare(strict_types=1);

namespace App\PersonnageCreator\Application\Query;

use App\PersonnageCreator\Domain\Repository\ProfessionRepositoryInterface;
use App\Repository\ProfessionRepository;

class FindProfessionQuery implements QueryInterface
{
    public function __construct(private ProfessionRepositoryInterface $professionRepository)
    {
    }
    public function ask(mixed $item = null)
    {
        return $this->professionRepository->getOne($item);
    }
}

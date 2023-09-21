<?php

declare(strict_types=1);

namespace App\PersonnageCreator\Domain\Repository;

use App\PersonnageCreator\Domain\Model\Profession;

interface ProfessionRepositoryInterface extends RepositoryInterface
{
    public function getOne(int $id): Profession|null;
    /**
     * @return <int,Profession>
     */
    public function getAll(): array;

    public function getWithPagination(int $page, int $limit): iterable;
}

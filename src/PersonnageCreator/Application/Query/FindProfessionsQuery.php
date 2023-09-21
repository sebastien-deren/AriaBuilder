<?php

declare(strict_types=1);

namespace App\PersonnageCreator\Application\Query;

class FindProfessionsQuery implements QueryInterface
{
    public function __construct(
        public int $page,
        public int $limit
    ) {
    }
}

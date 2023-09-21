<?php

declare(strict_types=1);

namespace App\PersonnageCreator\Application\Query;

class FindProfessionQuery implements QueryInterface
{
    public function __construct(
        public int $id
    ) {
    }
}

<?php

declare(strict_types=1);

namespace App\PersonnageCreator\Application\Query;

interface QueryInterface
{
    public function ask(mixed $item = null);
}

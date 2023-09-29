<?php

declare(strict_types=1);

namespace App\Domain\Logic\Interface;

interface RetrieveModelFromIri
{
    public function resolveIri(string $iri): object;
}

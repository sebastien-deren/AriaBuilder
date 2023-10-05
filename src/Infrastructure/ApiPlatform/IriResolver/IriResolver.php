<?php

declare(strict_types=1);

namespace App\Infrastructure\ApiPlatform\IriResolver;

use ApiPlatform\Api\IriConverterInterface;
use App\Domain\Logic\Interface\RetrieveModelFromIri;

class IriResolver implements RetrieveModelFromIri
{
    public function __construct(private IriConverterInterface $iriconverter)
    {
    }
    public function resolveIri($iri): object
    {
        return $this->iriconverter->getResourceFromIri($iri);
    }
}

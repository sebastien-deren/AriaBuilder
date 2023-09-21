<?php

declare(strict_types=1);

namespace App\PersonnageCreator\Infrastructure\ApiPlatform\Traits;

use ApiPlatform\Api\IriConverterInterface;

trait IriConverter
{
    public function __construct(private IriConverterInterface $iriConverterInterface)
    {
    }
    public function getIri(object $object): string
    {
        return $this->iriConverterInterface->getIriFromResource($object);
    }
}

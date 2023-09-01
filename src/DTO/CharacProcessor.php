<?php

declare(strict_types=1);

namespace App\DTO;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Api\IriConverterInterface;
use App\Domain\Personnages\Characteristiques\CharacBuilderInterface;

class CharacProcessor implements ProcessorInterface
{
    public function __construct(private IriConverterInterface $iriConverter, private CharacBuilderInterface $characBuilderInterface)
    {
    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $charac = $this->characBuilderInterface->build($data);
        $charac->setPersonnage($this->iriConverter->getResourceFromIri($data->getPersonnage()));
    }
}

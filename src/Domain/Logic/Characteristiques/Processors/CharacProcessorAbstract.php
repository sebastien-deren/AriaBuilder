<?php

declare(strict_types=1);

namespace App\Domain\Logic\Characteristiques\Processors;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Api\IriConverterInterface;

use Doctrine\ORM\EntityManagerInterface;

abstract class CharacProcessorAbstract implements ProcessorInterface, CharacBuilderInterface
{
    public function __construct(private IriConverterInterface $iriConverter, private EntityManagerInterface $entityManager)
    {
    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $charac = $this->build($data);
        $charac->setPersonnage($this->iriConverter->getResourceFromIri($data->getPersonnage()));
        $this->entityManager->persist($charac);
        $this->entityManager->flush();
        return $charac;
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Api\IriConverterInterface;
use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Command\CreateCompetencePersonnageInterface;


class PostProcessorBaseCompetence implements ProcessorInterface
{
    public function __construct(private PersistProcessor $persistProcessor, private CreateCompetencePersonnageInterface $command, private IriConverterInterface $iriConverter)
    {
    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $competence = $this->iriConverter->getResourceFromIri($data->competence);
        $personnage = $this->iriConverter->getResourceFromIri($data->personnage);
        $data = $this->command->handle($personnage, $competence);
        $data = $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        return $data;
    }
}

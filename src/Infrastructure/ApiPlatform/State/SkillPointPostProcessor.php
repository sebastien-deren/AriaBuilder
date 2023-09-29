<?php

declare(strict_types=1);

namespace App\Infrastructure\ApiPlatform\State;

use ApiPlatform\Api\IriConverterInterface;
use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Domain\Logic\Characteristiques\CaracConstructorInterface;

class SkillPointPostProcessor implements ProcessorInterface
{
    public function __construct(private PersistProcessor $persistProcessor, private CaracConstructorInterface $constructor)
    {
    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $data = $this->constructor->create($data);
        $data = $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        return $data;
    }
}

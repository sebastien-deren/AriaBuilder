<?php

namespace App\State;

use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Domain\Logic\Background\BackgroundCompetenceUpdaterInterface;

class BackgroundPostProcessor implements ProcessorInterface
{
    public function __construct(private PersistProcessor $persistProcessor, private BackgroundCompetenceUpdaterInterface $updater)
    {
    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        if ($operation instanceof Post) {
            $this->updater->updateCompetenceFromBackground($data);
        }
        $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}

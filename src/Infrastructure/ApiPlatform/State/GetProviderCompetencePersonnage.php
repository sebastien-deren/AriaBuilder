<?php

declare(strict_types=1);

namespace App\Infrastructure\ApiPlatform\State;

use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Request\GetCompetencePersonnageQuerry;
use App\Application\Request\GetCompetencePersonnageQuerryInterface;
use App\Infrastructure\ApiPlatform\Outputs\CompetencePersonnageOutput;
use App\Repository\CompetencePersonnageRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetProviderCompetencePersonnage implements ProviderInterface
{
    public function __construct(private CompetencePersonnageRepository $repository, private GetCompetencePersonnageQuerryInterface $querry, private ItemProvider $itemProvider)
    {
    }
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return $this->itemProvider->provide($operation, $uriVariables, $context);
    }
}

<?php

declare(strict_types=1);

namespace App\PersonnageCreator\Infrastructure\ApiPlatform\State\Profession\Provider;

use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\PersonnageCreator\Application\Query\FindProfessionQuery;
use App\PersonnageCreator\Application\Query\FindProfessionQueryHandler;
use App\PersonnageCreator\Infrastructure\ApiPlatform\Resource\ProfessionResource;


class ProfessionItemProvider implements ProviderInterface, ProviderQueryInterface
{
    public function __construct(
        private FindProfessionQueryHandler $findProfession
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $id = $uriVariables['id'];
        $model =  $this->findProfession->ask(new FindProfessionQuery((int)$id));
        return null !== $model ? ProfessionResource::fromModel($model) : null;
    }
}

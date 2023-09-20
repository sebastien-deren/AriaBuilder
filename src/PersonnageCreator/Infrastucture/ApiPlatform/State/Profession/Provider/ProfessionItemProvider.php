<?php

declare(strict_types=1);

namespace App\PersonnageCreator\Infrastucture\ApiPlatform\State\Profession\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\PersonnageCreator\Application\Query\FindProfessionQuery;
use App\PersonnageCreator\Infrastucture\ApiPlatform\Resource\ProfessionResource;
use App\PersonnageCreator\Infrastucture\ApiPlatform\State\Profession\Provider\ProviderQueryInterface;

class ProfessionItemProvider implements ProviderInterface, ProviderQueryInterface
{
    public function __construct(
        private FindProfessionQuery $findProfession
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $id = $uriVariables['id'];
        $model =  $this->findProfession->ask($id);
        return null !== $model ? ProfessionResource::fromModel($model) : null;
    }
}

<?php

declare(strict_types=1);

namespace App\PersonnageCreator\Infrastucture\ApiPlatform\State\Profession\Provider;

use ApiPlatform\Doctrine\Orm\Paginator;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\ArrayPaginator;
use ApiPlatform\State\ProviderInterface;
use App\PersonnageCreator\Application\Query\FindProfessionsQuery;
use App\PersonnageCreator\Infrastucture\ApiPlatform\Resource\ProfessionResource;
use App\Repository\ProfessionRepository;


class ProfessionCollectionProvider implements ProviderInterface
{

    public function __construct(private FindProfessionsQuery $findProfessions, private Paginator $paginator)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $limit = null;
        $offset = null;
        if ($this->pagination->isEnabled($operation, $context)) {
            $limit = $this->pagination->getLimit($operation, $context);
            $offset = $this->pagination->getPage($context);
        }
        //here we need to construct a query and so findProfessions is our queryHandler
        /*
        something like that ?
        $collection = new findProfessionsHandler(new findProfessionsQuery($limit,$offset))?
        Problem Our findProfessionHandler need DI for the repository
        */
        $model = $this->findProfessions->ask(['limit' => $limit, 'offset' => $offset]);

        $resources = [];
        foreach ($model as $item) {
            $resources[] = ProfessionResource::fromModel($item);
        }
        if (empty($resources)) {
            return null;
        }
        return  new ArrayPaginator($resources, $offset, $limit);
    }
}

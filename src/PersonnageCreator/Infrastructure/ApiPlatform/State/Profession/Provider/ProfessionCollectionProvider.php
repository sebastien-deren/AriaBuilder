<?php

declare(strict_types=1);

namespace App\PersonnageCreator\Infrastructure\ApiPlatform\State\Profession\Provider;

use ApiPlatform\Doctrine\Orm\Paginator;
use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\ArrayPaginator;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use App\PersonnageCreator\Application\Query\FindProfessionsQuery;
use App\PersonnageCreator\Application\Query\FindProfessionsQueryHandler;
use App\PersonnageCreator\Infrastructure\ApiPlatform\Resource\ProfessionResource;

class ProfessionCollectionProvider implements ProviderInterface
{

    public function __construct(private FindProfessionsQueryHandler $findProfessions, private Pagination $pagination)
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
        $model = $this->findProfessions->ask(new FindProfessionsQuery($offset, $limit));

        $resources = [];
        foreach ($model as $item) {
            $resources[] = ProfessionResource::fromModel($item);
        }

        return (new TraversablePaginator(new \ArrayIterator($resources), $offset, $limit, \count($resources)));
        //return  !empty($resources) ? $paginator : null;
    }
}

<?php

declare(strict_types=1);

namespace App\PersonnageCreator\Infrastructure\ApiPlatform\State\Profession\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use App\PersonnageCreator\Application\Query\FindProfessionsQuery;
use App\PersonnageCreator\Application\Query\FindProfessionsQueryHandler;

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
        $model = $this->findProfessions->ask(new FindProfessionsQuery($offset, $limit));
        return (new TraversablePaginator($model, $offset, $limit, count($model)));
    }
}

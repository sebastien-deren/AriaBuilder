<?php

namespace App\State;

use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Domain\Background\BackgroundEnum;
use App\Domain\Personnages\CompetencePersonnage\CompetencePersonnageUpdater;
use App\Domain\Personnages\CompetencePersonnage\CompetencePersonnageUpdaterInterface;
use App\Domain\Personnages\CompetencePersonnage\UpgradeCompetenceEnum;

class BackgroundPostProcessor implements ProcessorInterface
{
    public function __construct(private PersistProcessor $persistProcessor, private CompetencePersonnageUpdaterInterface $comPersoUpdater)
    {
    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $this->comPersoUpdater->updateCompetencePercentage($data->getCompetenceBonus(), $data->getPersonnage(), UpgradeCompetenceEnum::Bonus);
        $this->comPersoUpdater->updateCompetencePercentage($data->getCompetenceMalus(), $data->getPersonnage(), UpgradeCompetenceEnum::Malus);
        $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}

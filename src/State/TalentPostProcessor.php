<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Domain\Model\Talent;
use App\Domain\Personnages\CompetencePersonnage\UpgradeCompetenceEnum;
use App\Domain\Talent\TalentCompetenceUpdaterInterface;
use App\Domain\Talent\TalentCreationInterface;


class TalentPostProcessor implements ProcessorInterface
{

    public function __construct(private PersistProcessor $persistProcessor, private TalentCreationInterface $talentCreation, private TalentCompetenceUpdaterInterface $competenceUpdater)
    {
    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {

        if (!($data instanceof Talent)) {
            throw new \Exception('unreachable exception');
        }
        $data = $this->talentCreation->create($data);
        $data = $this->competenceUpdater->updateCompetenceFromTalent($data);
        $data = $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Logic\Competences\Processors;


use App\Domain\Logic\Competences\DTO\CompetenceAbstract;
use App\Domain\Model\Competence;
use App\Domain\Model\CompetencePersonnage;
use App\Domain\Model\Personnage;
use App\Infrastructure\ApiPlatform\Inputs\CalculusInput;

class CalculusProcessor extends AbstractProcessor
{
    /**
     * @param array<Competence> $baseCompetences
     */

    protected function buildCollection(CompetenceAbstract $data, array $baseCompetences, Personnage $personnage): array
    {
        if (!($data instanceof CalculusInput) || !$data->isCalculated) {
            throw new \Exception('you asked not to construct our baseCompetences');
        }
        foreach ($baseCompetences as $competence) {
            $methodName = 'get' . $competence->getFirstCharac()->value;
            $firstCharac = $personnage->getCaracteristique()->$methodName();
            $methodName = 'get' . $competence->getSecondCharac()->value;
            $secondCharac = $personnage->getCaracteristique()->$methodName();
            $value = (int)floor(($firstCharac + $secondCharac) / 2);
            $competencePersonnage = new CompetencePersonnage();
            $competencePersonnage->setCompetence($competence)->setPourcentage($value);
            $personnage->addCompetence($competencePersonnage);
            $this->entityManager->persist($competencePersonnage);
        }
        $this->entityManager->flush();

        return [];
    }
}

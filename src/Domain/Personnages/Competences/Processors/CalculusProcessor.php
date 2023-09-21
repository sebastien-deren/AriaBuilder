<?php

declare(strict_types=1);

namespace App\Domain\Personnages\Competences\Processors;


use App\Domain\Model\Competence;
use App\Domain\Model\Personnage;
use App\Domain\Model\CompetencePersonnage;
use App\DTO\Input\Competence\CalculusInput;
use App\DTO\Input\Competence\CompetenceInputAbstract;

class CalculusProcessor extends AbstractProcessor
{
    /**
     * @param array<Competence> $baseCompetences
     */

    protected function buildCollection(CompetenceInputAbstract $data, array $baseCompetences, Personnage $personnage): array
    {
        if (!($data instanceof CalculusInput) || !$data->isCalculated) {
            throw new \Exception('you asked not to construct our baseCompetences');
        }
        foreach ($baseCompetences as $competence) {
            $methodName = 'get' . $competence->getFirstCharac();
            $firstCharac = $personnage->getCaracteristique()->$methodName();
            $methodName = 'get' . $competence->getSecondCharac();
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

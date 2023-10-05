<?php

declare(strict_types=1);

namespace App\Domain\Logic\Talent;

use App\Domain\Exception\InvalidPersonnageException;
use App\Domain\Model\Caracteristique;
use App\Domain\Model\Talent;
use App\Domain\Logic\CompetencePersonnage\UpgradeCompetenceEnum;

class TalentCreation implements TalentCreationInterface
{
    public function create(Talent $talent): Talent
    {
        $carac = $talent->getPersonnage()->getCaracteristique();
        $this->setCaracBasedParameters($talent, $this->getValueCarac($carac))->validateNumberOfTalent($talent)->validatePersonnage($talent);
        return $talent;
    }
    private function getValueCarac(Caracteristique $caracteristique): TalentParam
    {
        $talentCategory = $caracteristique->getIntelligence() + $caracteristique->getCharisme();
        return match (true) {
            $talentCategory <= 40 => new TalentParam(0),
            $talentCategory <= 80 => new TalentParam(1, UpgradeCompetenceEnum::LitteBonus),
            $talentCategory <= 120 => new TalentParam(1, UpgradeCompetenceEnum::Bonus),
            $talentCategory <= 140 => new TalentParam(2, UpgradeCompetenceEnum::Bonus),
            $talentCategory <= 200 => new TalentParam(3, UpgradeCompetenceEnum::Bonus),
            default => new TalentParam(0),
        };
    }
    private function setCaracBasedParameters(Talent $talent, TalentParam $param): self
    {
        $talent->setBonus($param->bonus);
        $talent->setNumberOfTalent($param->talentNumber);
        return $this;
    }
    //WE need a logger here to tell us that We should have more or less Talent and notify it back to the user.
    private function validateNumberOfTalent(Talent $talent): self
    {
        $competence = $talent->getUpgradedCompetence();
        $numberOfItem = $competence->count();
        $maxItem = $talent->getNumberOfTalent();
        for ($i = $numberOfItem; $i > $maxItem; $i--) {
            $talent->removeUpgradedCompetence($competence->last());
        }
        return $this;
    }
    //TOMOVE into validator Class
    private function validatePersonnage(Talent $talent): self
    {
        foreach ($talent->getUpgradedCompetence() as $competence) {
            if ($competence->getPersonnage() !== $talent->getPersonnage()) {
                throw new InvalidPersonnageException('Access Right Exception');
            }
        }
        return $this;
    }
}

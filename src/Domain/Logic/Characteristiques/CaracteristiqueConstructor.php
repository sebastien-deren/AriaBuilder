<?php

declare(strict_types=1);

namespace App\Domain\Logic\Characteristiques;

use App\Domain\Interface\RetrieveModelFromIri;
use App\Domain\Logic\Characteristiques\CharacLimitEnum;
use App\Domain\Logic\Characteristiques\DTO\AbstractSkillInput;
use App\Domain\Logic\Characteristiques\Exception\PointException;
use App\Domain\Model\Caracteristique;

class CaracteristiqueConstructor implements CaracConstructorInterface
{
    public function __construct(private RetrieveModelFromIri $retriever)
    {
    }
    public function create(AbstractSkillInput $skillInput): Caracteristique
    {
        $caracteristique = new Caracteristique();
        $arrayCarac = $skillInput->toArray();
        $point = 0;
        foreach ($skillInput as $characKey => $characValue) {
            if ($characValue > CharacLimitEnum::Max100->value || $characValue < CharacLimitEnum::Min100->value) {
                throw new PointException("you can't have a characteristic bellow" . CharacLimitEnum::Min100->value . "or supperior to " . CharacLimitEnum::Max100->value,);
            }
            $point += $characValue;
            $fn = 'set' . ucfirst($characKey);
            $caracteristique->$fn($characValue);
        }
        if (250 != $point) {
            throw new PointException("your point total should be 250 it is " . $point);
        }
        $caracteristique->setPersonnage($this->retriever->resolveIri($skillInput->getPersonnage()));
        return $caracteristique;
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Personnages\Characteristiques\Processors;

use App\Domain\Model\Caracteristique;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Api\IriConverterInterface;
use App\DTO\Inputs\Characteristics\InputAbstract;
use App\Domain\Personnages\Characteristiques\CharacLimitEnum;

class CharacPointProcessor extends CharacProcessorAbstract
{
    public function __construct(private IriConverterInterface $iriConverterInterface, private EntityManagerInterface $entityManager)
    {
        parent::__construct($iriConverterInterface, $entityManager);
    }

    public function build(InputAbstract $characInput): Caracteristique
    {
        $builtCharac = new Caracteristique();
        $point = 0;
        foreach ($characInput->toArray() as $characValue) {
            if ($characValue > CharacLimitEnum::Max100->value || $characValue < CharacLimitEnum::Min100->value) {
                throw new \Exception("you can't have a characteristic bellow" . CharacLimitEnum::Min100->value . "or supperior to " . CharacLimitEnum::Max100->value,);
            }
            $point += $characValue;
        }
        if ($point !== 250) {
            throw new \Exception("your point total should be 250 it is " . $point);
        }
        $builtCharac
            ->setCharisme($characInput->charisme)
            ->setDexterite($characInput->dexterite)
            ->setForce($characInput->force)
            ->setEndurance($characInput->endurance)
            ->setIntelligence($characInput->intelligence);
        return $builtCharac;
    }
}

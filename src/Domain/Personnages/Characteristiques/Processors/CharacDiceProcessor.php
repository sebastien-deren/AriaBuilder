<?php

declare(strict_types=1);

namespace App\Domain\Personnages\Characteristiques\Processors;

use App\Domain\Model\Caracteristique;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Api\IriConverterInterface;
use App\DTO\Inputs\Characteristics\DiceInput;
use App\DTO\Inputs\Characteristics\InputAbstract;
use App\Domain\Personnages\Characteristiques\CharacLimitEnum;

class CharacDiceProcessor extends CharacProcessorAbstract
{
    use DicesTrait;
    public function __construct(private IriConverterInterface $iriConverterInterface, private EntityManagerInterface $entityManager)
    {
        parent::__construct($iriConverterInterface, $entityManager);
    }

    public function build(InputAbstract $characInput): Caracteristique
    {
        if (!($characInput instanceof DiceInput)) {
            throw new \Exception('unreachable');
        }
        if (5 !== count($dice = $characInput->getDices())) {
            throw new \Exception("you didn't submit the good number of dices");
        }
        foreach ($characInput->toArray() as $characValue) {
            if ($characValue > CharacLimitEnum::Max20->value || $characValue < CharacLimitEnum::Min20->value) {
                throw new \Exception("you can't have a characteristic bellow" . CharacLimitEnum::Min20->value . "or supperior to " . CharacLimitEnum::Max20->value,);
            }
            $found = \array_search($characValue, $dice);
            if (false === $found) {
                throw new \Exception("you don't have a dice with this value" . $characValue);
            }
            \array_splice($dice, $found, 1);
        }
        return $this->createTwenty($characInput);
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Personnages\Characteristiques\Processors;

use App\Domain\Model\Caracteristique;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Api\IriConverterInterface;
use App\DTO\Inputs\Characteristics\InputAbstract;
use App\Domain\Personnages\Characteristiques\CharacLimitEnum;
use App\Domain\Personnages\Characteristiques\Processors\DicesTrait;
use App\DTO\Inputs\Characteristics\DiceInput;

class CharacThreeDicesProcessor extends CharacProcessorAbstract
{
    use DicesTrait;
    public function __construct(private IriConverterInterface $iriConverterInterface, private EntityManagerInterface $entityManager)
    {
        parent::__construct($iriConverterInterface, $entityManager);
    }

    public function build(InputAbstract $baseCharac): Caracteristique
    {
        if (!($baseCharac instanceof DiceInput)) {
            throw new \Exception('unreachable');
        }
        if (3 !== count($sets = $baseCharac->getDices())) {
            throw new \Exception("you didn't submit the good number of set of dices");
        }
        foreach ($baseCharac->toArray() as $characValue) {
            if ($characValue > CharacLimitEnum::Max20 || $characValue < CharacLimitEnum::Min20) {
                throw new \Exception("you can't have a characteristic bellow" . CharacLimitEnum::Min20->value . "or supperior to " . CharacLimitEnum::Max20->value,);
            }
            $sets = $this->checkThreeSets($sets, $characValue);
            if (empty($sets)) {
                throw new \Exception('no sets of dice corresponds to your characteristics');
            }
        }
        return $this->createTwenty($baseCharac);
    }



    private function checkThreeSets(array $sets, int $value): array
    {
        foreach ($sets as $dicesKey => $dices) {
            $found = \array_search($value, $dices);
            if (false === $found) {
                unset($sets[$dicesKey]);
            } else {
                \array_splice($dices, $found, 1);
            }
        }
        return $sets;
    }
}

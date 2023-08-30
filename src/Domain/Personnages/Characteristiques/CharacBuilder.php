<?php

declare(strict_types=1);

namespace App\Domain\Personnages\Characteristiques;


use App\Controller\Characteristics;
use App\Domain\Model\Caracteristique;
use App\Domain\Personnages\Characteristiques\CharacBuilderInterface;

class CharacBuilder implements CharacBuilderInterface
{
    public function build(Characteristics $baseCharac): Caracteristique
    {
        return match ($baseCharac->getRules()) {
            CharacRules::Dice => $this->buildDice($baseCharac),
            CharacRules::Point => $this->buildPoint($baseCharac),
            CharacRules::ThreeDices => $this->buildThreeDices($baseCharac),
        };
    }

    private function buildPoint(Characteristics $baseCharac): Caracteristique
    {
        $builtCharac = new Caracteristique();
        $point = 0;
        foreach ($baseCharac as $characValue) {
            if ($characValue > CharacLimitEnum::Max100->value || $characValue < CharacLimitEnum::Min100->value) {
                throw new \Exception("you can't have a characteristic bellow" . CharacLimitEnum::Min100->value . "or supperior to " . CharacLimitEnum::Max100->value,);
            }
            $point += $characValue;
        }
        if ($point !== 250) {
            throw new \Exception("your point total should be 250 it is " . $point);
        }
        $builtCharac
            ->setCharisme($baseCharac->charisme)
            ->setDexterite($baseCharac->dexterite)
            ->setForce($baseCharac->force)
            ->setEndurance($baseCharac->endurance)
            ->setIntelligence($baseCharac->intelligence);
        return $builtCharac;
    }

    private function buildDice(Characteristics $baseCharac): Caracteristique
    {
        if (5 !== count($dice = $baseCharac->getDices())) {
            throw new \Exception("you didn't submit the good number of dices");
        }
        foreach ($baseCharac as $characValue) {
            if ($characValue > CharacLimitEnum::Max20->value || $characValue < CharacLimitEnum::Min20->value) {
                throw new \Exception("you can't have a characteristic bellow" . CharacLimitEnum::Min20->value . "or supperior to " . CharacLimitEnum::Max20->value,);
            }
            $found = \array_search($characValue, $dice);
            if (false === $found) {
                throw new \Exception("you don't have a dice with this value" . $characValue);
            }
            \array_splice($dice, $found, 1);
        }
        return $this->createTwenty($baseCharac);
    }

    private function buildThreeDices(Characteristics $baseCharac): Caracteristique
    {

        if (3 !== count($sets = $baseCharac->getDices())) {
            throw new \Exception("you didn't submit the good number of set of dices");
        }
        foreach ($baseCharac as $characValue) {
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

    private function createTwenty(Characteristics $baseCharac): Caracteristique
    {
        return (new Caracteristique())
            ->setCharisme(($baseCharac->charisme * 5))
            ->setDexterite(($baseCharac->dexterite * 5))
            ->setForce(($baseCharac->force * 5))
            ->setEndurance(($baseCharac->endurance * 5))
            ->setIntelligence(($baseCharac->intelligence * 5));
    }

    private function checkThreeSets($sets, $value): array
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

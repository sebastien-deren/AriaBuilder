<?php

declare(strict_types=1);

namespace App\Tests\Domain\Model\Personnage\Characteristiques;

use PHPUnit\Framework\TestCase;
use App\Controller\Characteristics;
use App\Domain\Personnages\Characteristiques\CharacRules;
use App\Domain\Personnages\Characteristiques\CharacBuilder;
use App\Domain\Personnages\Characteristiques\CharacLimitEnum;

class CharacBuilderTest extends TestCase
{
    private CharacBuilder $builder;

    public function setUp(): void
    {
        $this->builder = new CharacBuilder();
    }

    /**
     * @dataProvider pointProviderGood
     */
    public function testBuildPoint(array $value)
    {
        $baseCharac = $this->characConstruct($value);
        $baseCharac->setRules(CharacRules::Point);
        $charac = $this->builder->build($baseCharac);
        $this->assertEquals($baseCharac->charisme, $charac->getCharisme());
    }
    public function pointProviderGood()
    {
        return array(
            array([50, 50, 50, 50, 50]),
            array([40, 60, 70, 30, 50]),
            array([80, 80, 10, 10, 70]),
        );
    }
    /**
     * @dataProvider pointProviderBad
     */
    public function testBuildPointFalsy(array $value, string $errorMessage)
    {
        $baseCharac = $this->characConstruct($value);
        $baseCharac->setRules(CharacRules::Point);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage($errorMessage);
        $charac = $this->builder->build($baseCharac);
    }
    public function pointProviderBad()
    {
        return array(
            array([(CharacLimitEnum::Min100->value - 1), 50, 50, 50, 50], 'you can\'t have a characteristic bellow'),
            array([40, (CharacLimitEnum::Max100->value + 1), 70, 30, 50], 'you can\'t have a characteristic bellow'),
            array([80, 80, 10, 10, 20], 'your point total should be 250 it is ' . (string)(80 + 80 + 10 + 10 + 20)),
        );
    }

    /**
     * @dataProvider goodDicesProvider
     */
    public function testBuildDice(array $value)
    {
        $baseCharac = $this->characConstruct($value);
        $baseCharac->setRules(CharacRules::Dice);
        \shuffle($value);
        $baseCharac->setDices($value);
        $charac = $this->builder->build($baseCharac);
        $this->assertEquals(($baseCharac->charisme * 5), $charac->getCharisme());
    }
    public function goodDicesProvider()
    {
        return array(
            array([12, 12, CharacLimitEnum::Max20->value, 12, CharacLimitEnum::Min20->value],)
        );
    }
    /**
     * @dataProvider badDicesProvider
     */
    public function testBuildDiceFalsy(array $value, string $errorMessage, array $dices = [])
    {
        if (empty($dices)) {
            $dices = $value;
        }
        $baseCharac = $this->characConstruct($value);
        $baseCharac->setRules(CharacRules::Dice);
        $baseCharac->setDices($dices);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage($errorMessage);
        $this->builder->build($baseCharac);
    }
    public function badDicesProvider()
    {
        return array(
            array(
                [12, 12, (CharacLimitEnum::Max20->value + 1), 12, CharacLimitEnum::Min20->value],
                "you can't have a characteristic bellow" . CharacLimitEnum::Min20->value . "or supperior to " . CharacLimitEnum::Max20->value,
            ),
            array(
                [12, 12, (CharacLimitEnum::Max20->value), 12, (CharacLimitEnum::Min20->value - 1)],
                "you can't have a characteristic bellow" . CharacLimitEnum::Min20->value . "or supperior to " . CharacLimitEnum::Max20->value,
            ),
            array(
                [12, 12, (CharacLimitEnum::Max20->value), 12, CharacLimitEnum::Min20->value],
                "you don't have a dice with this value",
                [12, 12, CharacLimitEnum::Max20->value, 11, CharacLimitEnum::Min20->value],
            ),
            array(
                [12, 12, (CharacLimitEnum::Max20->value), 12, CharacLimitEnum::Min20->value],
                "you didn't submit the good number of dices",
                [12, 12, 12, 12],
            ),

        );
    }
    private function characConstruct(array $value): Characteristics
    {

        $baseCharac = new Characteristics();
        $baseCharac->charisme = $value[0];
        $baseCharac->dexterite = $value[1];
        $baseCharac->endurance = $value[2];
        $baseCharac->force = $value[3];
        $baseCharac->intelligence = $value[4];
        return $baseCharac;
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Domain\Model\Personnage\Characteristiques;

use PHPUnit\Framework\TestCase;
use App\Domain\Model\Personnage;
use ApiPlatform\Api\IriConverterInterface;
use App\DTO\CharacteristicsInput as Characteristics;
use App\Domain\Personnages\Characteristiques\CharacRules;
use App\Domain\Personnages\Characteristiques\CharacBuilder;
use App\Domain\Personnages\Characteristiques\CharacLimitEnum;

class CharacBuilderTest extends TestCase
{
    private CharacBuilder $builder;

    public function setUp(): void
    {
        $IriConverter = $this->getMockBuilder(IriConverterInterface::class)->onlyMethods(['getResourceFromIri', 'getIriFromResource'])->getMock();
        $IriConverter->expects($this->never())->method('getResourceFromIri')->willReturn(new Personnage());
        $this->builder = new CharacBuilder($IriConverter);
    }

    /**
     * @dataProvider pointProviderGood
     */
    public function testBuildPoint(array $value): void
    {
        $baseCharac = $this->characConstruct($value);
        $baseCharac->setRules(CharacRules::Point->value);
        $charac = $this->builder->build($baseCharac);
        $this->assertEquals($baseCharac->charisme, $charac->getCharisme());
    }
    public function pointProviderGood(): array
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
    public function testBuildPointFalsy(array $value, string $errorMessage): void
    {
        $baseCharac = $this->characConstruct($value);
        $baseCharac->setRules(CharacRules::Point->value);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage($errorMessage);
        $charac = $this->builder->build($baseCharac);
    }
    public function pointProviderBad(): array
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
    public function testBuildDice(array $value): void
    {
        $baseCharac = $this->characConstruct($value);
        $baseCharac->setRules(CharacRules::Dice->value);
        \shuffle($value);
        $baseCharac->setDices($value);
        $charac = $this->builder->build($baseCharac);
        $this->assertEquals(($baseCharac->charisme * 5), $charac->getCharisme());
    }
    public function goodDicesProvider(): array
    {
        return array(
            array([12, 12, CharacLimitEnum::Max20->value, 12, CharacLimitEnum::Min20->value],)
        );
    }
    /**
     * @dataProvider badDicesProvider
     */
    public function testBuildDiceFalsy(array $value, string $errorMessage, array $dices = []): void
    {
        if (empty($dices)) {
            $dices = $value;
        }
        $baseCharac = $this->characConstruct($value);
        $baseCharac->setRules(CharacRules::Dice->value);
        $baseCharac->setDices($dices);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage($errorMessage);
        $this->builder->build($baseCharac);
    }
    public function badDicesProvider(): array
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

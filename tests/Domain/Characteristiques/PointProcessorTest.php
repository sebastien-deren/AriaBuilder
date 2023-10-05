<?php

namespace App\Tests\Domain\Characteristiques;

use App\Domain\Interface\RetrieveModelFromIri;
use App\Domain\Logic\Characteristiques\CaracteristiqueConstructor;
use App\Domain\Logic\Characteristiques\CharacLimitEnum;
use App\Domain\Logic\Characteristiques\Exception\PointException;
use App\Domain\Model\Personnage;
use App\Infrastructure\ApiPlatform\Inputs\SkillPointsInput;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PointProcessorTest extends TestCase
{

    private MockObject $retriever;
    public function setUp(): void
    {

        $this->retriever = $this->getMockBuilder(RetrieveModelFromIri::class)->onlyMethods(['resolveIri'])->getMock();
        $this->pointProcessor = new CaracteristiqueConstructor($this->retriever);
    }
    /**
     * @dataProvider pointProviderGood
     */
    public function testBuildPoint(array $value): void
    {
        $this->retriever->expects($this->once())->method('resolveIri')->willReturn(new Personnage());
        $skill = new SkillPointsInput($value[0], $value[1], $value[2], $value[3], $value[4], 'personnage');
        $charac = $this->pointProcessor->create($skill);
        $this->assertEquals($skill->charisme, $charac->getCharisme());
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
        $this->retriever->expects($this->never())->method('resolveIri');
        $skill = new SkillPointsInput($value[0], $value[1], $value[2], $value[3], $value[4], 'personnage');
        $this->expectException(PointException::class);
        $this->expectExceptionMessage($errorMessage);
        $baseCharac = $this->pointProcessor->create($skill);
    }
    public function pointProviderBad(): array
    {
        return array(
            array([(CharacLimitEnum::Min100->value - 1), 50, 50, 50, 50], 'you can\'t have a characteristic bellow'),
            array([40, (CharacLimitEnum::Max100->value + 1), 70, 30, 50], 'you can\'t have a characteristic bellow'),
            array([80, 80, 10, 10, 20], 'your point total should be 250 it is ' . (string)(80 + 80 + 10 + 10 + 20)),
        );
    }
}

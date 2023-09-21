<?php

namespace App\Tests\Domain\Characteristics;

use PHPUnit\Framework\TestCase;
use App\Domain\Model\Personnage;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Api\IriConverterInterface;
use ApiPlatform\Metadata\GraphQl\Operation;
use PHPUnit\Framework\MockObject\MockObject;
use App\DTO\Inputs\Characteristics\DiceInput;
use App\Domain\Personnages\Characteristiques\CharacLimitEnum;
use App\Domain\Personnages\Characteristiques\Processors\CharacDiceProcessor;

class DiceProcessorTest extends TestCase
{
    use CharacConstruct;

    private CharacDiceProcessor $diceProcessor;
    private Operation $post;
    private MockObject $entityManager;
    private MockObject $iriConverter;

    public function setUp(): void
    {
        $this->iriConverter = $this->getMockBuilder(IriConverterInterface::class)->onlyMethods(['getResourceFromIri', 'getIriFromResource'])->getMock();
        $this->entityManager = $this->getMockBuilder(EntityManagerInterface::class)->getMock();
        $this->post = new Operation();
        $this->diceProcessor = new CharacDiceProcessor($this->iriConverter, $this->entityManager);
    }
    /**
     * @dataProvider goodDicesProvider
     */
    public function testBuildDice(array $value): void
    {
        $this->iriConverter->expects($this->once())->method('getResourceFromIri')->willReturn(new Personnage());
        $this->entityManager->expects($this->once())->method('persist');
        $this->entityManager->expects($this->once())->method('flush');
        $baseCharac = $this->characConstruct($value, new DiceInput());
        \shuffle($value);
        $baseCharac->setDices($value);
        $charac = $this->diceProcessor->process($baseCharac, $this->post);
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
        $this->entityManager->expects($this->never())->method('persist');
        $this->entityManager->expects($this->never())->method('flush');
        $this->iriConverter->expects($this->never())->method('getResourceFromIri');
        if (empty($dices)) {
            $dices = $value;
        }
        $baseCharac = $this->characConstruct($value, new DiceInput());
        $baseCharac->setDices($dices);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage($errorMessage);
        $this->diceProcessor->process($baseCharac, $this->post);
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
}

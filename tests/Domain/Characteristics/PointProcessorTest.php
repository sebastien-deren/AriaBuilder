<?php

namespace App\Tests\Domain\Characteristics;

use PHPUnit\Framework\TestCase;
use App\Domain\Model\Personnage;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Api\IriConverterInterface;
use ApiPlatform\Metadata\GraphQl\Operation;
use App\Domain\Logic\Characteristiques\CharacLimitEnum;
use App\Domain\Logic\Characteristiques\Processors\CharacPointProcessor;
use App\DTO\Inputs\Characteristics\PointInput;
use PHPUnit\Framework\MockObject\MockObject;

class PointProcessorTest extends TestCase
{
    use CharacConstruct;

    private CharacPointProcessor $pointProcessor;
    private Operation $post;
    private MockObject $entityManager;
    private MockObject $iriConverter;
    public function setUp(): void
    {
        $this->iriConverter = $this->getMockBuilder(IriConverterInterface::class)->onlyMethods(['getResourceFromIri', 'getIriFromResource'])->getMock();

        $this->entityManager = $this->getMockBuilder(EntityManagerInterface::class)->getMock();


        $this->post = new Operation();
        $this->pointProcessor = new CharacPointProcessor($this->iriConverter, $this->entityManager);
    }
    /**
     * @dataProvider pointProviderGood
     */
    public function testBuildPoint(array $value): void
    {
        $this->entityManager->expects($this->once())->method('persist');
        $this->entityManager->expects($this->once())->method('flush');
        $this->iriConverter->expects($this->once())->method('getResourceFromIri')->willReturn(new Personnage());
        $baseCharac = $this->characConstruct($value, new PointInput());
        $charac = $this->pointProcessor->process($baseCharac, $this->post);
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
        $this->entityManager->expects($this->never())->method('persist');
        $this->entityManager->expects($this->never())->method('flush');
        $this->iriConverter->expects($this->never())->method('getResourceFromIri');
        $baseCharac = $this->characConstruct($value, new PointInput());
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage($errorMessage);
        $charac = $this->pointProcessor->process($baseCharac, $this->post);
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

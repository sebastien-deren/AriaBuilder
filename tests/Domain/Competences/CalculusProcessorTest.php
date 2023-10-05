<?php

namespace App\Tests;

use ApiPlatform\Metadata\GraphQl\Operation;
use App\Domain\Logic\Competences\Processors\CalculusProcessor;
use App\Infrastructure\ApiPlatform\Inputs\CalculusInput;
use App\Infrastructure\Doctrine\Repository\CompetenceRepository;
use App\Infrastructure\Doctrine\Repository\PersonnageRepository;
use App\Tests\Factory\CaracteristiqueFactory;
use App\Tests\Factory\CompetenceFactory;
use App\Tests\Factory\PersonnageFactory;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

use Zenstruck\Foundry\Test\Factories;

class CalculusProcessorTest extends TestCase
{
    use Factories;

    private MockObject $entityManager;
    private MockObject $competenceRepository;
    private MockObject $personnageRepository;
    private CalculusProcessor $processor;
    private Operation $post;


    public function setUp(): void
    {
        $this->post = new Operation();
        $this->entityManager = $this->getMockBuilder(EntityManagerInterface::class)->getMock();
        $this->competenceRepository = $this->getMockBuilder(CompetenceRepository::class)->disableOriginalConstructor()->getMock();
        $this->personnageRepository = $this->getMockBuilder(PersonnageRepository::class)->disableOriginalConstructor()->getMock();

        $this->processor = new CalculusProcessor($this->entityManager, $this->competenceRepository, $this->personnageRepository);
    }

    public function testCalculusGood(): void
    {
        $calculusInput = $this->createCalculusInput();
        $baseCompetence = CompetenceFactory::new()->based()->createMany(4);
        $carac = CaracteristiqueFactory::createOne();
        $personnage = PersonnageFactory::createOne(['caracteristique' => $carac]);
        $this->personnageRepository->expects($this->once())->method('find')->willReturn($personnage->object());
        $this->competenceRepository->expects($this->once())->method('findby')->willReturn(array_map(fn ($item) => $item->object(), $baseCompetence));
        $this->entityManager->expects($this->exactly(count($baseCompetence)))->method('persist');
        $this->entityManager->expects($this->once())->method('flush');
        $this->processor->process($calculusInput, $this->post, ['id_perso' => 1]);
        $charac1 = 'get' . $baseCompetence[0]->getFirstCharac()->value;
        $charac2 = 'get' . $baseCompetence[0]->getSecondCharac()->value;
        $this->assertEquals(
            floor(($personnage->getCaracteristique()->$charac1()  + $personnage->getCaracteristique()->$charac2()) / 2),
            $personnage->getCompetence()[0]->getPourcentage()
        );
    }
    public function createCalculusInput(bool $set = true)
    {
        $calculusInput = new CalculusInput();
        $calculusInput->isCalculated = $set;
        return $calculusInput;
    }
}

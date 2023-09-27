<?php

namespace App\Tests\Domain\Logic\Talent;

use App\Domain\Model\Caracteristique;
use App\Domain\Model\Competence;
use App\Domain\Model\CompetencePersonnage;
use App\Domain\Model\Personnage;
use App\Domain\Model\Talent;
use App\Domain\Logic\CompetencePersonnage\UpgradeCompetenceEnum;
use App\Domain\Logic\Talent\TalentCreation;
use Exception;
use PHPUnit\Framework\TestCase;

class TalentCreationTest extends TestCase
{
    /**
     * @dataProvider sucessTalentProvider
     */
    public function testTalentCreationSucess(int $charisma, int $intelligence, int $numberOfTalent, UpgradeCompetenceEnum $Value = UpgradeCompetenceEnum::Default): void
    {
        $caracteristique = $this->createStub(Caracteristique::class);
        $caracteristique->method('getCharisme')->willReturn($charisma);
        $caracteristique->method('getIntelligence')->willReturn($intelligence);
        $personnage = $this->createStub(Personnage::class);
        $personnage->method('getCaracteristique')->willReturn($caracteristique);


        $talent = (new Talent())->setBonus($Value)->setNumberOfTalent($numberOfTalent)->setPersonnage($personnage);
        for ($i = 0; $i < 5; $i++) {
            $stubComp = $this->createStub(CompetencePersonnage::class);
            $stubComp->method('getPersonage')->willReturn($personnage);
            $talent->addUpgradedCompetence($stubComp);
        }

        $result = (new TalentCreation())->create($talent);
        $this->assertEquals($numberOfTalent, $talent->getUpgradedCompetence()->count());
    }

    public function sucessTalentProvider(): array
    {
        return array(
            [20, 30, 1, UpgradeCompetenceEnum::LitteBonus],
            [40, 90, 2, UpgradeCompetenceEnum::Bonus],
            [30, 70, 1, UpgradeCompetenceEnum::Bonus],
            [100, 100, 3, UpgradeCompetenceEnum::Bonus],
            [0, 0, 0],
            [200, 400, 0],
            [-100, 50, 0]
        );
    }
    public function testTalentCreationWrongPerso()
    {
        $caracteristique = $this->createStub(Caracteristique::class);
        $caracteristique->method('getCharisme')->willReturn(50);
        $caracteristique->method('getIntelligence')->willReturn(50);
        $personnage = $this->createStub(Personnage::class);
        $personnage->method('getCaracteristique')->willReturn($caracteristique);
        $anotherPersonnage = $this->createStub(Personnage::class);
        $talent = (new Talent())->setBonus(UpgradeCompetenceEnum::Bonus)->setNumberOfTalent(3)->setPersonnage($personnage);
        for ($i = 0; $i < 5; $i++) {
            $stubComp = $this->createStub(CompetencePersonnage::class);
            $stubComp->method('getPersonage')->willReturn($anotherPersonnage);
            $talent->addUpgradedCompetence($stubComp);
        }
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Access Right Exception');

        $result = (new TalentCreation())->create($talent);
    }
}

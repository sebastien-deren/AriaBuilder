<?php

declare(strict_types=1);

namespace App\Tests\Domain\Logic\Talent;

use App\Domain\Model\CompetencePersonnage;
use App\Domain\Model\Talent;
use App\Domain\Logic\CompetencePersonnage\UpgradeCompetenceEnum;
use App\Domain\Logic\Talent\TalentCompetenceUpdater;
use PHPUnit\Framework\TestCase;

class TalentUpdateCompetenceTest extends TestCase
{
    /**
     * @dataProvider pourcentProvider
     */
    public function testTalentUpdateCompetence(int $pourcentage, UpgradeCompetenceEnum $valueBonus)
    {
        $talent = (new Talent())->setBonus($valueBonus);
        $competencePersonnage = (new CompetencePersonnage())->setPourcentage($pourcentage);
        $talent->addUpgradedCompetence($competencePersonnage);
        $result = (new TalentCompetenceUpdater())->updateCompetenceFromTalent($talent);
        $this->assertEquals($result->getUpgradedCompetence()->first()->getPourcentage(), $pourcentage + $valueBonus->value);
    }
    public function pourcentProvider(): array
    {
        return array(
            [20, UpgradeCompetenceEnum::Bonus],
            [10, UpgradeCompetenceEnum::Default],
            [50, UpgradeCompetenceEnum::LitteBonus]
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Functionnal;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Domain\Model\CompetencePersonnage;
use App\Domain\Model\Talent;
use App\Domain\Logic\CompetencePersonnage\UpgradeCompetenceEnum;
use App\Factory\CaracteristiqueFactory;
use App\Factory\CompetenceFactory;
use App\Factory\CompetencePersonnageFactory;
use App\Factory\PersonnageFactory;
use Zenstruck\Foundry\Test\ResetDatabase;

class TalentTest extends ApiTestCase
{
    use ResetDatabase;
    public function setUp(): void
    {
        static::bootKernel();
        $this->entityManager = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->talentRepository = $this->entityManager->getRepository(Talent::class);
    }
    /**
     * @dataProvider talentCategoryProvider
     */
    public function testPostGoodTalent(int $charisma, int $intelligence, int $numberoftalent, UpgradeCompetenceEnum $enum = UpgradeCompetenceEnum::Default)
    {
        $competences = CompetenceFactory::createMany(5);
        $carac = CaracteristiqueFactory::createOne(['charisme' => $charisma, 'intelligence' => $intelligence]);
        $personnage = PersonnageFactory::new()->characterized($carac)->create();
        $competencePersonnage = [];
        foreach ($competences as $competence) {
            $competencePersonnage[] = CompetencePersonnageFactory::createOne(['personnage' => $personnage, 'competence' => $competence])->save();
        }
        $oldCompetence = ['pourcentage' => $competencePersonnage[0]->getPourcentage(), 'id' => $competencePersonnage[0]->getId()];
        $response = static::createClient()->request(
            'POST',
            'api/talent',
            [
                'json' => [
                    'personnage' => 'api/personnages/' . $personnage->getId(),
                    'upgradedCompetence' => [
                        'api/competence_personnages/' . $competencePersonnage[0]->object()->getId(),
                        'api/competence_personnages/' . $competencePersonnage[1]->object()->getId(),
                        'api/competence_personnages/' . $competencePersonnage[2]->object()->getId()
                    ]
                ]
            ]
        );
        $this->assertResponseIsSuccessful();
        $talent = $this->talentRepository?->findOneBy(['personnage' => $personnage->getId()]);
        $this->assertNotNull($talent);
        $this->assertEquals($numberoftalent, $talent->getUpgradedCompetence()->count());
        $this->assertEquals($enum, $talent->getBonus());
        $competencePersonnage = $this->entityManager->getRepository(CompetencePersonnage::class)->find($oldCompetence['id']);
        $this->assertEquals($oldCompetence['pourcentage'] + $enum->value, $competencePersonnage->getPourcentage());
    }

    public function talentCategoryProvider(): array
    {
        return array(
            [0, 0, 0],
            [25, 25, 1, UpgradeCompetenceEnum::LitteBonus],
            [50, 50, 1, UpgradeCompetenceEnum::Bonus],
            [65, 65, 2, UpgradeCompetenceEnum::Bonus],
            [80, 80, 3, UpgradeCompetenceEnum::Bonus]
        );
    }
}

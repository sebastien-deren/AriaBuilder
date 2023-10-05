<?php

namespace App\Tests\Functionnal;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Domain\Logic\CompetencePersonnage\UpgradeCompetenceEnum;
use App\Domain\Model\Background;
use App\Domain\Model\CompetencePersonnage;
use App\Infrastructure\Doctrine\Repository\BackgroundRepository;
use App\Infrastructure\Doctrine\Repository\CompetencePersonnageRepository;
use App\Tests\Factory\CompetenceFactory;
use App\Tests\Factory\CompetencePersonnageFactory;
use App\Tests\Factory\PersonnageFactory;
use Doctrine\ORM\EntityManager;
use Faker\Factory;
use Zenstruck\Foundry\Test\ResetDatabase;

class BackgroundTest extends ApiTestCase
{
    use ResetDatabase;
    private EntityManager $entityManager;
    private BackgroundRepository $backgroundRepository;
    private CompetencePersonnageRepository $comPersoRepository;
    public function setUp(): void
    {
        static::bootKernel();
        $this->entityManager = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->backgroundRepository = $this->entityManager->getRepository(Background::class);
        $this->comPersoRepository = $this->entityManager->getRepository(CompetencePersonnage::class);
    }
    public function testBackgroundCreationSucessful(): void
    {
        $faker = Factory::create();
        $competenceMalus = CompetenceFactory::createOne();
        $competenceBonus = CompetenceFactory::createOne();
        $personnage = PersonnageFactory::createOne([]);
        $competencePersonnage = [];
        $competencePersonnage['bonus'] = CompetencePersonnageFactory::createOne(['personnage' => $personnage, 'competence' => $competenceBonus]);
        $oldBonusPercentage = $competencePersonnage['bonus']->getPourcentage();
        $competencePersonnage['malus'] = CompetencePersonnageFactory::createOne(['personnage' => $personnage, 'competence' => $competenceMalus]);
        $oldMalusPercentage = $competencePersonnage['malus']->getPourcentage();
        $description = $faker->paragraph();
        $response = $this->createClient()->request('POST', 'api/backgrounds', [
            'json' => [
                'competenceBonus' => 'api/competence_personnages/' . $competencePersonnage['bonus']->getId(),
                'competenceMalus' => 'api/competence_personnages/' . $competencePersonnage['malus']->getId(),
                'description' => $description,
                'personnage' => 'api/personnages/' . $personnage->getId(),
            ]
        ]);
        $this->assertResponseIsSuccessful();
        $background = $this->backgroundRepository?->findOneBy(['personnage' => $personnage->object()]);
        $this->assertNotNull($background);
        $this->assertStringContainsString('"description":"' . $background->getDescription() . '"', $response->getContent());
        $bonusComp = $this->comPersoRepository?->find($competencePersonnage['bonus']->getId());
        $malusComp = $this->comPersoRepository?->find($competencePersonnage['malus']->getId());
        $this->assertEquals($oldBonusPercentage + UpgradeCompetenceEnum::Bonus->value, $bonusComp->getPourcentage());
        $this->assertEquals($oldMalusPercentage + UpgradeCompetenceEnum::Malus->value, $malusComp->getPourcentage());
    }
}

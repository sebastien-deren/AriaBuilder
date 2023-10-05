<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Domain\Logic\Competences\SubCompetenceEnum;
use App\Domain\Model\Caracteristique;
use App\Domain\Model\CompetencePersonnage;
use App\Tests\Factory\CaracteristiqueFactory;
use App\Tests\Factory\CompetenceFactory;
use App\Tests\Factory\CompetencePersonnageFactory;
use App\Tests\Factory\PersonnageFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Zenstruck\Foundry\Test\ResetDatabase;

class CompetencePersonnageTest extends ApiTestCase
{
    use ResetDatabase;
    public EntityManager $entityManager;
    public function setUp(): void
    {
        static::bootKernel();
        $this->entityManager = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }
    public function testPostCompetencePersonnage(): void
    {
        $carac = CaracteristiqueFactory::createOne();
        $competence = CompetenceFactory::createOne(['firstCharac' => SubCompetenceEnum::Force, 'secondCharac' => SubCompetenceEnum::Intelligence, 'isBaseCompetence' => true]);
        $personnage = PersonnageFactory::createOne(['caracteristique' => $carac]);
        $response = static::createClient()->request(
            'POST',
            'api/base_competence/auto',
            [
                'json' => [
                    'personnage' => 'api/personnages/' . $personnage->getId(),
                    'competence' => 'api/competences/' . $competence->getId()
                ]
            ]
        );
        $competencePersonnage = $this->entityManager->getRepository(CompetencePersonnage::class)->findOneBy([]);
        $this->assertNotNull($competencePersonnage);
        $this->assertEquals((int)(($carac->getForce() + $carac->getIntelligence()) / 2), $competencePersonnage->getPourcentage());
        $this->assertResponseIsSuccessful();
    }
    public function testGetCompetencePersonnage(): void
    {
        $competencePersonnage = CompetencePersonnageFactory::createOne();
        $response = static::createClient()->request(
            'GET',
            'api/competence_personnages/' . $competencePersonnage->getId(),
        );
        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('api\/competence_personnages\/' . $competencePersonnage->getId(), $response->getContent());
    }
}

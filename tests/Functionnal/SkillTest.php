<?php

declare(strict_types=1);

namespace App\Tests\Functionnal;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Domain\Model\Caracteristique;
use App\Tests\Factory\PersonnageFactory;
use Doctrine\ORM\EntityManager;
use Zenstruck\Foundry\Test\ResetDatabase;

class SkillTest extends ApiTestCase
{
    use ResetDatabase;

    private EntityManager $entityManager;
    public function setUp(): void
    {
        static::bootKernel();
        $this->entityManager = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }
    public function testPost()
    {
        $personnage = PersonnageFactory::createOne();
        $response = static::createClient()->request(
            'POST',
            'api/caracteristiques/points',
            [
                'json' => [
                    'intelligence' => 80,
                    'force' => 50,
                    "endurance" => 20,
                    'dexterite' => 50,
                    "charisme" => 50,
                    "personnage" => 'api/personnages/' . $personnage->getId(),
                ]
            ]
        );
        $this->assertResponseIsSuccessful();
        $repo = $this->entityManager->getRepository(Caracteristique::class);
        $skill = $repo->findOneBy([]);
        $this->assertNotNull($skill);
        $this->assertEquals($personnage->getId(), $skill->getPersonnage()->getId());
    }
}

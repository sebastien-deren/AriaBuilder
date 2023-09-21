<?php

namespace App\Tests\Functionnal;

use Doctrine\ORM\EntityManager;
use App\Factory\CompetenceFactory;
use Zenstruck\Foundry\Test\ResetDatabase;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Factory\ProfessionFactory;
use Doctrine\Common\Collections\ArrayCollection;

class professionTest extends ApiTestCase
{
    use ResetDatabase;

    private EntityManager $entityManager;
    public function setUp(): void
    {
        static::bootKernel();
        $this->entityManager = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }
    public function testGetProfession(): void
    {
        $competences = CompetenceFactory::createMany(2);
        $profession = ProfessionFactory::createOne((['competenceProfessions' => (new ArrayCollection(\array_map(fn ($comp) => $comp->object(), $competences)))]));
        $response = static::createClient()->request(
            'GET',
            'api/professions/' . $profession->getId()
        );
        $this->assertResponseIsSuccessful();
    }
    public function testGetCollectionProfession(): void
    {
        $competences = CompetenceFactory::createMany(2);
        $profession = ProfessionFactory::createMany(4, ['competenceProfessions' => (new ArrayCollection(\array_map(fn ($comp) => $comp->object(), $competences)))]);
        $response = static::createClient()->request(
            'GET',
            'api/professions'
        );
        $this->assertResponseIsSuccessful();
    }
}

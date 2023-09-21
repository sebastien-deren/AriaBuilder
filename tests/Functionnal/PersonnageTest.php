<?php

namespace App\Tests\Functionnal;

use Doctrine\ORM\EntityManager;
use App\Factory\CompetenceFactory;
use App\Factory\PersonnageFactory;
use App\Factory\ProfessionFactory;
use Zenstruck\Foundry\Test\ResetDatabase;
use App\Factory\CompetencePersonnageFactory;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Doctrine\Common\Collections\ArrayCollection;

class PersonnageTest extends ApiTestCase
{
    use ResetDatabase;

    private EntityManager $entityManager;
    public function setUp(): void
    {
        static::bootKernel();
        $this->entityManager = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }
    public function testGetCollection(): void
    {
        PersonnageFactory::createMany(5);
        $response = static::createClient()->request('GET', '/api/personnages');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains(['@id' => '/api/personnages']);
        $this->assertJsonContains(["hydra:totalItems" => 5]);
    }
    public function testGetOne(): void
    {
        $personnage = PersonnageFactory::createOne();
        $response = static::createClient()->request('GET', '/api/personnages/' . $personnage->getId());
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains(['@id' => '/api/personnages/' . $personnage->getId()]);
        $this->assertJsonContains(['nom' => $personnage->getNom()]);
    }
    public function testPostOne(): void
    {
        $personnage =
            [
                "nom" => 'name',
                "prenom" => "name",
                "age" => "18",
                "genie" => "yes",
                "society" => 'no'
            ];
        $response = static::createClient()->request('POST', 'api/personnages', ["headers" => ['Accept' => 'application/ld+json'], "json" => $personnage]);
        $this->assertResponseStatusCodeSame(201);
    }
    public function testPatchProfession(): void
    {
        $competence = CompetenceFactory::createOne();
        $personnage = PersonnageFactory::createOne([]);
        $competencePersonnage = CompetencePersonnageFactory::createOne(['personage' => $personnage, 'competence' => $competence]);
        $collection = new ArrayCollection([$competence->object()]);
        $profession = ProfessionFactory::createOne(['competenceProfessions' => $collection]);
        $oldPercentage = $competencePersonnage->getPourcentage();
        $response = static::createClient()->request(
            'PATCH',
            '/api/personnages/' . $personnage->getId(),
            [
                'json' => ["profession" => 'api/professions/' . $profession->getId()],
                'headers' => ['Content-Type' => 'application/merge-patch+json'],
            ]

        );

        //dd($response->getContent());
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['profession' => '/api/professions/1']);
        //$this->assertJsonContains(['pourcentage' => 20]);
        $this->assertEquals($competencePersonnage->getPourcentage(), ($oldPercentage + 10));
        $this->assertEquals($personnage->getProfession(), $profession);
    }
}

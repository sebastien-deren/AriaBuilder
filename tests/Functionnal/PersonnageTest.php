<?php

namespace App\Tests\Functionnal;

use ApiPlatform\OpenApi\Model\Header;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Util\CachedTrait;
use App\Domain\Model\Competence;
use App\Domain\Model\CompetencePersonnage;
use App\Domain\Model\Personnage;
use App\Factory\CompetenceFactory;
use App\Factory\CompetencePersonnageFactory;
use App\Factory\PersonnageFactory;
use App\Factory\ProfessionFactory;
use Zenstruck\Foundry\Test\ResetDatabase;

class PersonnageTest extends ApiTestCase
{
    use ResetDatabase;
    public function setUp(): void
    {
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
        $personnage = PersonnageFactory::new()->characterized()->skilled()->createOne();
        $profession = ProfessionFactory::new()->skilled()->createOne();
        $comp = (new CompetencePersonnage())
            ->setCompetence(CompetenceFactory::find([])->object())
            ->setPersonage($personnage->object())
            ->setPourcentage(10);
        $personnage->addCompetence($comp);
        $profession->addCompetenceProfession((CompetenceFactory::find([]))->object());
        $personnage->save();
        $profession->save();
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
        $this->assertEquals($comp->getPourcentage(), 20);
        $this->assertEquals($personnage->getProfession()->getId(), $profession->getId());
    }
}

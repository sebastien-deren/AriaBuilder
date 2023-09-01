<?php

namespace App\Tests\Functionnal;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Util\CachedTrait;
use App\Domain\Model\Personnage;
use App\Factory\PersonnageFactory;
use App\Repository\PersonnageRepository;
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
}

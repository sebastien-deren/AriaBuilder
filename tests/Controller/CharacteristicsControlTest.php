<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class CharacteristicsControlTest extends ApiTestCase
{
    public function testSomething(): void
    {
        $response = static::createClient()->request('GET', '/api/characteristics');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['id' => 4]);
    }
}

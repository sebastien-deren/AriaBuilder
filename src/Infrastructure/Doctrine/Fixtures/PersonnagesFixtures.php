<?php

namespace App\Infrastructure\Doctrine\Fixtures;

use App\Domain\Model\Caracteristique;
use App\Domain\Model\Personnage;
use App\Tests\Factory\PersonnageFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PersonnagesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        PersonnageFactory::createMany(40);
    }
}

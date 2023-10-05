<?php

namespace App\Infrastructure\Doctrine\Fixtures;

use App\Domain\Data\MageEnum;
use App\Domain\Model\CompetenceProfession;
use App\Domain\Model\Profession;
use App\Infrastructure\Doctrine\Repository\CompetenceRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

/**
 * @codeCoverageIgnore
 */
class ProfessionFixture extends Fixture
{
    public function __construct(
        #[Autowire("%kernel.project_dir%/data/")] private string $rootDir,

        private CompetenceRepository $competenceRepository
    ) {
    }
    public function load(ObjectManager $manager): void
    {
        $fileJson = \file_get_contents($this->rootDir . "Profession.json");
        $professions = \json_decode($fileJson); // $product = new Product();
        foreach ($professions as $profession) {
            $professionEntity = new Profession();
            $professionEntity->setNom($profession->name);
            foreach ($profession->bonus as $competenceBonus) {
                $competence = $this->competenceRepository->findOneBy(["nom" => $competenceBonus]);
                $professionEntity->addCompetenceProfession($competence);
            }
            $manager->persist($professionEntity);
        }


        $manager->flush();
    }
}

<?php

declare(strict_types=1);

namespace App\DataFixtures;

use stdClass;
use Psr\Log\LoggerInterface;
use App\Domain\Model\Competence;
use Doctrine\Persistence\ObjectManager;
use App\Domain\Data\CaracteristiquesEnum;
use App\Domain\Logic\Competences\SubCompetenceEnum;
use App\Domain\Model\Caracteristique;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CompetenceFixtures extends Fixture
{
    public function __construct(
        private string $rootDir,
        private LoggerInterface $logger
    ) {
    }

    public function load(ObjectManager $manager)
    {
        $json = \file_get_contents($this->rootDir . '/src/Domain/Data/competences.json');
        $competences = \json_decode($json, false);
        foreach ($competences as $competences) {
            if ($this->checkJson($competences)) {
                $storageCompetence = (new Competence())
                    ->setNom($competences->name)
                    ->setDescription($competences->description)
                    ->setFirstCharac(SubCompetenceEnum::from($competences->secondCharac))
                    ->setSecondCharac(SubCompetenceEnum::from($competences->firstCharac))
                    ->setIsBaseCompetence(true);
                $manager->persist($storageCompetence);
            }
        }
        $manager->flush();
    }
    private function checkJson(stdClass $competence): bool
    {
        if (!isset($competence->name)) {
            $this->logger->alert("one competence in our Fixture doesn't have a name");
            return false;
        }
        if (!isset($competence->description)) {
            $this->logger->alert($competence->name . "doesn't have a description, it is not fine for a base competence");
            return false;
        }
        if (!isset($competence->secondCharac) || !\in_array($competence->firstCharac, array_column(SubCompetenceEnum::cases(), 'name'))) {
            dd(CaracteristiquesEnum::cases());
            $this->logger->alert($competence->name . "doesn't have a firstCharac, this is not fine for a base competence");
            return false;
        }
        if (!isset($competence->firstCharac) || !\in_array($competence->firstCharac, array_column(SubCompetenceEnum::cases(), 'name'))) {
            $this->logger->alert($competence->name . "doesn't have a secondCharac, this is not fine for a base competence");
            return false;
        }
        return true;
    }
}

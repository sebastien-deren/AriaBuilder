<?php

namespace App\Domain\Model;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\DTO\Input\Competence\CalculusInput;
use App\Repository\CompetencePersonnageRepository;
use App\Domain\Logic\Competences\Processors\CalculusProcessor;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompetencePersonnageRepository::class)]
#[ApiResource(
    operations: [new Get()]
)]
#[ApiResource(
    uriTemplate: 'personnages/{id_perso}/competences.{_format}',
    uriVariables: [
        'id_perso' => new Link(
            fromProperty: 'competence',
            fromClass: Personnage::class
        )
    ],
    operations: [new GetCollection(), new Post(), new Patch()]

)]
#[ApiResource(
    uriTemplate: 'personnage/{id_perso}/base_competence.{_format}',
    uriVariables: [
        'id_perso' => new Link(
            fromProperty: 'competence',
            fromClass: Personnage::class
        )
    ],
    operations: [new Post(input: CalculusInput::class, processor: CalculusProcessor::class)],
)]
class CompetencePersonnage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups("personnage:read")]
    #[ORM\Column]
    private ?int $pourcentage = null;

    #[ORM\ManyToOne(inversedBy: 'competence')]
    private ?Personnage $personage = null;

    #[ORM\ManyToOne]
    private ?Competence $competence = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPourcentage(): ?int
    {
        return $this->pourcentage;
    }

    public function setPourcentage(int $pourcentage): static
    {
        $this->pourcentage = $pourcentage;

        return $this;
    }

    public function getPersonage(): ?Personnage
    {
        return $this->personage;
    }

    public function setPersonage(?Personnage $personage): static
    {
        $this->personage = $personage;

        return $this;
    }

    public function getCompetence(): ?Competence
    {
        return $this->competence;
    }

    public function setCompetence(?Competence $competence): static
    {
        $this->competence = $competence;

        return $this;
    }
}
